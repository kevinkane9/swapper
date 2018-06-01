<?php

use Sapper\Db,
    Sapper\Route,
    Sapper\Util;

if ($action = Route::uriParam('action')) {
    switch ($action) {
        case 'get-data':
            $totalCount = Db::fetchColumn(
                'SELECT COUNT(*) AS `count` FROM `sap_download_filtered`',
                [],
                'count'
            );

            $query = 'SELECT d.*, DATE_FORMAT(d.`created_on`, "%b %e, %Y") AS `date`
                        FROM `sap_download_filtered` d';

            $params = [
                'offset'    => (int) $_POST['start'],
                'rowCount'  => (int) $_POST['length'],
            ];

            if (!empty($_POST['search']['value']) && '' !== $_POST['search']['value']) {
                $query .= ' WHERE d.filename LIKE :filename';
                $params['filename'] = '%' . $_POST['search']['value'] . '%';
            }

            $query .= ' ORDER BY d.`id` DESC LIMIT :offset, :rowCount';


            $downloads = Db::fetchAll($query, $params);
            $listRequestTitles = [];
            if (!empty($downloads)) {
                foreach ($downloads as $k=>$download) {
                    $d_client_id = $download['client_id'];
                    $d_client_name = $download['client_name'];
                    $outreachAccountId = Db::fetchColumn(
                        'SELECT * FROM `sap_client_account_outreach` WHERE `client_id` = :client_id',
                        ['client_id' => $d_client_id],
                        'id'
                    );
                            
                    $requestIndex = Db::fetchColumn(
                        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                        ['id' => $outreachAccountId],
                        'request_index'
                    );

                    if (!is_int($requestIndex) || !($requestIndex > 0)) {
                        $requestCount = (int) Db::fetchColumn(
                                'SELECT COUNT(*) AS `count`
                           FROM `sap_list_request`
                          WHERE `outreach_account_id` = :outreach_account_id',
                                ['outreach_account_id' => $outreachAccountId],
                                'count'
                            ) + 1;

                        Db::query(
                            'UPDATE `sap_client_account_outreach` SET `request_index` = :request_count WHERE `id` = :id',
                            [
                                'request_count' => $requestCount,
                                'id'            => $outreachAccountId
                            ]
                        );

                        $requestIndex = $requestCount;
                    }

                    $listRequestTitle = $d_client_name . ' ' . $requestIndex . ' () ' . date('mdy');
                    
                    $downloads[$k]['outreach_account_id'] = $outreachAccountId;
                    $downloads[$k]['list_request_title'] = $listRequestTitle;
                }
            }

            jsonResponse(
                [
                    'draw'            => (int) $_REQUEST['draw'],
                    'downloads'       => $downloads,
                    'recordsTotal'    => $totalCount,
                    'recordsFiltered' => $totalCount
                ]
            );
            break;

        case 'download':
            $download = Db::fetch(
                'SELECT * FROM `sap_download_filtered` WHERE `id` = :id',
                ['id' => Route::uriParam('id')]
            );

            $file     = $download[Route::uriParam('type')];

            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . str_replace(',', '', $file));
            header('Pragma: no-cache');
            readfile('upload/' . $download['created_on'] . '/' . $file);
            exit;
            break;

        case 'delete':
            $download = Db::fetch(
                'SELECT * FROM `sap_download_filtered` WHERE `id` = :id',
                ['id' => Route::uriParam('id')]
            );

            unlink('upload/' . $download['created_on'] . '/' . $download['nidb']);
            unlink('upload/' . $download['created_on'] . '/' . $download['idbnor']);
            unlink('upload/' . $download['created_on'] . '/' . $download['idbior']);

            Db::query(
                'DELETE FROM `sap_download_filtered` WHERE `id` = :id LIMIT 1',
                ['id' => Route::uriParam('id')]
            );

            // check if any processing background jobs are for this download
            $jobs = Db::fetchAll('SELECT * FROM `sap_background_job` WHERE `status` = "processing"');

            foreach ($jobs as $job) {
                $data = json_decode($job['data'], true);

                if ('normaliz-csv-filtered' == $data['type'] && $data['download_id'] == $download['id']) {
                    Db::query(
                        'UPDATE `sap_background_job` SET `status` = "deleted" WHERE `id` = :id',
                        ['id' => $job['id']]
                    );
                }
            }

            header('Location: /downloads-filtered');
            exit;
            break;

        case 'save':
            $downloadId = Route::uriParam('id');

            if (!($downloadId > 0)) {
                header('Location: /downloads');
                exit;
            }

            $download = Db::fetch(
                'SELECT * FROM `sap_download` WHERE `id` = :id',
                ['id' => $downloadId]
            );

            $file = fopen('upload/' . $download['created_on'] . '/' . $download['filtered'], 'r');
            
            // skip headers
            $headers = fgetcsv($file);

            $prospectIds = [];
                
            while ($row = fgetcsv($file)) {

                //[0] => First Name
                //[1] => Last Name
                //[2] => Email
                //[3] => Title
                //[4] => Account
                //[5] => Company
                //[6] => Work Phone
                //[7] => Mobile Phone
                //[8] => Website
                //[9] => Address
                //[10] => City
                //[11] => State
                //[12] => Zip
                //[13] => Country
                //[14] => Revenue
                //[15] => Employees
                //[16] => Company Industry
                //[17] => Source
                //[18] => Sapper Client Segment

                $prospectId  = Db::fetchColumn(
                    'SELECT * FROM `sap_prospect` WHERE `email` = :email',
                    ['email' => $row[2]],
                    'id'
                );

                if ($prospectId > 0) {
                    $prospectIds[] = $prospectId;
                } else {
                    try {
                        $prospectId = Db::insert(
                            'INSERT INTO `sap_prospect`
                             (`email`, `first_name`, `last_name`, `title`, `company_id`, `phone_work`, `phone_personal`,
                              `address`, `city_id`, `state_id`, `zip`, `country_id`, `company_revenue`,
                              `company_employees`, `industry_id`, `source_id`)
                              VALUES
                             (:email, :first_name, :last_name, :title, :company_id, :phone_work, :phone_personal,
                              :address, :city_id, :state_id, :zip, :country_id, :company_revenue,
                              :company_employees, :industry_id, :source_id)',
                            [
                                'email' => $row[2],
                                'first_name' => $row[0],
                                'last_name' => $row[1],
                                'title' => $row[3],
                                'company_id' => Util::prospectAttributeId('prospect_company', $row[5]),
                                'phone_work' => $row[6],
                                'phone_personal' => $row[7],
                                'address' => $row[9],
                                'city_id' => Util::prospectAttributeId('prospect_city', $row[10]),
                                'state_id' => Util::prospectAttributeId('prospect_state', $row[11]),
                                'zip' => $row[12],
                                'country_id' => Util::prospectAttributeId('prospect_country', $row[13]),
                                'company_revenue' => $row[14],
                                'company_employees' => $row[15],
                                'industry_id' => Util::prospectAttributeId('prospect_industry', $row[16]),
                                'source_id' => Util::prospectAttributeId('prospect_source', $row[17])
                            ]
                        );

                        $prospectIds[] = $prospectId;
                    } catch (\Exception $e) {
                        throw $e;
                    }
                }
            }

            foreach ($prospectIds as $prospectId) {
                Db::insert(
                    'INSERT INTO `sap_download_prospect` (`download_id`, `prospect_id`)
                              VALUES (:download_id, :prospect_id)',
                    [
                        'download_id' => $downloadId,
                        'prospect_id' => $prospectId
                    ]
                );
            }

            Db::query(
                'UPDATE `sap_download` SET `saved_to_db` = 1 WHERE `id` = :id',
                ['id' => $downloadId]
            );

            header('Location: /downloads');
            exit;
            break;

        case 'upload-to-outreach':
            Db::insert(
                'INSERT INTO `sap_background_job` (`data`) VALUES (:data)',
                [
                    'data' => json_encode(
                        [
                            'type'                 => 'upload-normalized-csv',
                            'outreach_account_id'  => $_POST['accountId'],
                            'download_id'          => $_POST['downloadId'],
                            'tag'                  => $_POST['tag']
                        ],
                        JSON_UNESCAPED_SLASHES
                    )
                ]
            );

            Db::query(
                'UPDATE `sap_download` SET `uploaded_to_outreach` = 1
                  WHERE `id` = :id',
                ['id' => $_POST['downloadId']]
            );

            jsonSuccess();
            break;
    }
}

$downloads = Db::fetchAll('SELECT * FROM sap_download_filtered ORDER BY id DESC');

$accounts = [];
foreach (
    Db::fetchAll(
        'SELECT a.*, c.`name`
           FROM `sap_client_account_outreach` a
      LEFT JOIN `sap_client` c ON a.`client_id` = c.`id`
       ORDER BY c.`name` ASC, a.`email` ASC'
    ) as $account
) {
    if (!array_key_exists($account['name'], $accounts)) {
        $accounts[$account['name']] = [];
    }
    $accounts[$account['name']][] = $account;
}

$assignableUsers = Db::fetchAll('SELECT * FROM `sap_user` WHERE `permissions` LIKE "%fulfill-list-requests%"');

sapperView(
    'downloads-filtered',
    [
        'downloads'       => $downloads,
        'assignableUsers'       => $assignableUsers,
        'companyAccounts' => $accounts
    ]
);
