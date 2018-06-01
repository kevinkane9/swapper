<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_background_job` WHERE `status` = "processing"');

if ($count['count'] >= 7) {
    echo 'Max # of jobs already in progress';
    exit;
}

if (array_key_exists(1, $argv)) {
    $job = Db::fetch(
        'SELECT  *
           FROM `sap_background_job`
          WHERE `id` = :id',
        ['id' => $argv[1]]
    );
} else {
    $job = Db::fetch(
        'SELECT  *
             FROM `sap_background_job`
             WHERE `status` = "ready"'
    );
}

try {
if (!empty($job)) {
    $jobId = $job['id'];

    $data = json_decode($job['data'], true);
    
    switch ($data['type']) {
        case 'normaliz-csv-filtered':
            $download_id = $data['download_id'];
            $post = $data['post'];
            $file = $data['file'];
            $file_name = basename($file);

            Db::query(
                'UPDATE `sap_background_job` SET `status` = "processing", `pid` = :pid WHERE `id` = :id',
                [
                    'pid' => getmypid(),
                    'id'  => $job['id']
                ]
            );
            
            Db::query(
                'UPDATE `sap_download_filtered` SET `status` = "Processing" WHERE `id` = :id',
                ['id' => $download_id]
            );            
            
            $geoEncode = false;

            if (!empty($post['geotarget']) && !empty($post['geotarget_lat']) && !empty($post['geotarget_lng'])) {
                $geoEncode = true;
            }

            $post['download_id'] = $download_id;

            $results = Sapper\ProspectsFilter::process(
                $file,
                $file_name,
                $post,
                false,
                false,
                $geoEncode
            );
            
            Db::query(
                'UPDATE `sap_download_filtered` SET `status` = "Complete" WHERE `id` = :id',
                ['id' => $download_id]
            );            
            
            Db::query(
                'UPDATE `sap_background_job` SET `status` = "complete" WHERE `id` = :id',
                ['id' => $job['id']]
            );
            
            break;
        case 'upload-normalized-csv-filtered':            
            $download_id = $data['download_filtered_id'];
            $list_request_id = $data['list_request_id'];
            $client_id = $data['client_id'];
            $prospectIds = $data['prospect_ids'];
            
            $download_filtered = Db::fetch(
                'SELECT * FROM `sap_download_filtered` WHERE `id` = :download_id',
                ['download_id' => $download_id]
            );

            $filename = $download_filtered['filename'];
            
            
            $account = Db::fetch(
                'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $data['outreach_account_id']]
            );
            
            Db::query(
                'UPDATE `sap_background_job` SET `status` = "processing", `pid` = :pid WHERE `id` = :id',
                [
                    'pid' => getmypid(),
                    'id'  => $job['id']
                ]
            );
            
            Db::query(
                "UPDATE `sap_list_request` "
                    . "SET `status` = 'Processing'"
                    . "WHERE `id` = :id",
                [
                    'id' => $list_request_id,
                ]
            );            

            // apply prospects to Outreach account
            if (0 == count($prospectIds)) {
                killJob($job, 'no prospects to sync to outreach');
            }

            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $account['client_id']],
                'name'
            );

            $tagName = $data['tag'];
            $tagId   = Util::prospectAttributeId('prospect_tag', $tagName);
            
            ################ Past Downloads ##############
            $total_rows = $prospectIds;
            ################ Past Downloads ##############

            foreach ($prospectIds as $prospectId) {
                $prospect_details[$prospectId] = Db::fetch(
                    'SELECT  p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                             pci.`name` AS `city`, pst.`name` AS `state`, ps.`name` AS `source`
                       FROM `sap_prospect` p
                  LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                  LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                  LEFT JOIN `sap_prospect_city` pci ON p.`city_id` = pci.`id`
                  LEFT JOIN `sap_prospect_state` pst ON p.`state_id` = pst.`id`
                  LEFT JOIN `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                      WHERE p.`id` = :prospect_id',
                    ['prospect_id' => $prospectId]
                ); 
            }
            
            ###########################
            # SiftLogic verification
            
            $listCertifiedBad = [];
            
            $listCertified = true; // Forcefully setting to true
            
            if (true == $listCertified) {
                $pathEnd = date('Y-m-d') . '/' . str_replace([' ', '.'], '', microtime());
                $path    = APP_ROOT_PATH . '/upload/' . $pathEnd;

                if (!is_dir(APP_ROOT_PATH . '/upload/' . date('Y-m-d'))) {
                    mkdir(APP_ROOT_PATH . '/upload/' . date('Y-m-d'));
                }

                if (!is_dir($path)) {
                    mkdir($path);
                }

                $listCertifiedFile  = $path . '/' . time() . '.csv';

                $listCertifiedInput = fopen($listCertifiedFile, 'w');

                fputcsv(
                    $listCertifiedInput,
                        [
                            'subscriber_email',
                            'subscriber_fname',
                            'subscriber_lname',
                            'subscriber_phone',
                            'subscriber_mobile',
                            'subscriber_addr1',
                            'subscriber_city',
                            'subscriber_state',
                            'subscriber_zip',
                            'subscriber_country'
                        ]
                );
                
                foreach ($prospect_details as $prospectId=>$prospect) {
                    fputcsv(
                        $listCertifiedInput,
                        [
                            !empty($prospect['email'])        ? $prospect['email']        : '',
                            !empty($prospect['first_name'])        ? $prospect['first_name']        : '',
                            !empty($prospect['last_name'])        ? $prospect['last_name']        : '',
                            !empty($prospect['phone_work'])        ? $prospect['phone_work']        : '',
                            !empty($prospect['phone_personal'])        ? $prospect['phone_personal']        : '',
                            !empty($prospect['address'])        ? $prospect['address']        : '',
                            !empty($prospect['city'])        ? $prospect['city']        : '',
                            !empty($prospect['state'])        ? $prospect['state']        : '',
                            !empty($prospect['zip'])        ? $prospect['zip']        : '',
                            !empty($prospect['country'])        ? $prospect['country']        : '',
                        ]
                    );
                }    
                
                fclose($listCertifiedInput);

                $iCount=1;
                try {
                    operations:
                        $operations = new \Operations(
                            \Operations::http(),
                            'sapper_suite',
                            '76a9d38c-7a0c-4cab-8fea-c7825b8c03a1',
                            8080,
                            'api.mydatamanage.com',
                            10,
                            'http'
                        );
        
                        $operations->init(); 
                } catch (\Exception $e) {
                    if (stristr($e->getMessage(), 'Unable to connect') !== FALSE) {
                        if ($iCount <= 3) {
                            $iCount++;
                            sleep(10);

                            goto operations;
                        } else {
                            throw $e;
                        }
                    }
                }
                
                // upload
                list($err, $message) = $operations->upload($listCertifiedFile, true);
                
                                
                if (!$err){
                    print("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - $message");
                    # throw new \RuntimeException($message);
                }

                // poll + download
                list($err, $message, $zip) = $operations->download($path, true);
                if (!$err){
                    print("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - $message");
                    //throw new \RuntimeException($message);
                }
                
                $archive = new \ZipArchive;
                if ($archive->open($path . '/' . $zip) === TRUE) {
                    $archive->extractTo($path);
                    $archive->close();
                } else {
                    print("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - Unable to unzip listCertified results");
                    #throw new \Exception('Unable to unzip listCertified results');
                }

                if (!file_exists($path . '/results.csv')) {
                    print("Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id: Siftlogic message - ListCertified results empty");
                    #throw new \Exception('listCertified results empty');
                }
                
                $results = fopen($path . '/results.csv', 'r');
                fgetcsv($results);

                while ($row = fgetcsv($results)) {
                    if ('bad' == $row[1] || $row[3] < 0) {
                        $listCertifiedBad[] = strtolower($row[0]);
                    }
                }                
            }
            
            ###########################
            
            foreach ($prospect_details as $prospectId=>$prospect) {
                $account = Db::fetch(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                    ['id' => $data['outreach_account_id']]
                );
                
                $outreachProspect = Db::fetch(
                    'SELECT *
                    FROM `sap_outreach_prospect`
                    WHERE `prospect_id` = :prospect_id
                     AND `outreach_account_id` = :outreach_account_id',
                    ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                );                

                // purge list
                if (!empty($prospect)) {
                    $row = $prospect;
                    
                    $emailParts = explode('@', $row['email']);
                    if (isset($emailParts[1])) {
                        $select = Db::query(
                            'SELECT * FROM `sap_client_dne` WHERE `client_id` = :client_id AND `domain` = :domain',
                            [
                                'client_id' => $data['client_id'],
                                'domain'    => '@' . $emailParts[1]
                            ]
                        );

                        if ($select->rowCount() > 0 || in_array($row['email'], $listCertifiedBad)) {
                            if (in_array($row['email'], $listCertifiedBad)) {
                                $purgeReason = 'List Certified marked as bad';
                            } else {
                                $purgeReason = 'Client DNE';
                            }
                            
                            $keepRow = false;
                            $rows_purged[$purgeReason . '_' . $prospectId] = $row;
                        } else {
                            $keepRow = true;
                            $rows_filtered[]   = $row;
                        }                       
                    }
                }   

                if ($keepRow) {
                    if (false !== $outreachProspect) {
                        // tag prospect
                        $tags = [$tagName];
                        foreach(
                            Db::fetchAll(
                                'SELECT t.`name`
                           FROM `sap_outreach_prospect_tag` opt
                      LEFT JOIN `sap_prospect_tag` t ON opt.`tag_id` = t.`id`
                          WHERE opt.`outreach_prospect_id` = :outreach_prospect_id',
                                ['outreach_prospect_id' => $outreachProspect['id']]
                            ) as $tag
                        ) {
                            $tags[] = $tag['name'];
                        }

                        Db::insert(
                            'INSERT INTO `sap_outreach_prospect_tag` (`outreach_prospect_id`, `tag_id`)
                          VALUES (:outreach_prospect_id, :tag_id)',
                            [
                                'outreach_prospect_id' => $outreachProspect['id'],
                                'tag_id'               => $tagId
                            ]
                        );

                        $response = Sapper\Api\Outreach::call(
                            'prospects/' . $outreachProspect['id'],
                            json_encode(['data' => ['attributes' => ['metadata' => ['tags' => [$tagName]]]]]),
                            $account['access_token'],
                            'patch'
                        );
                        
                        print("\n\n Process Request Log [upload-normalized-csv-filtered] Patch: Client Id $client_id Download Id $download_id List Request Id $list_request_id Prospect email {$row['email']} Outreach Response Status {$response['status']} Prospect ID {$response['data']['data']['id']}");                        

                        if (404 == $response['data']['errors'][0]['status']) {
                            Db::fetch(
                                'DELETE
                           FROM `sap_outreach_prospect`
                          WHERE `prospect_id` = :prospect_id
                            AND `outreach_account_id` = :outreach_account_id',
                                ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                            );
                            goto syncNewProspect23;
                        }
                    } else {
                        syncNewProspect23:
                        // import prospect
                        $prospect = Db::fetch(
                        'SELECT  p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                                 pci.`name` AS `city`, pst.`name` AS `state`, psc.`name` AS `country`, ps.`name` AS `source`
                           FROM `sap_prospect` p
                      LEFT JOIN `sap_prospect_company` pc ON p.`company_id` = pc.`id`
                      LEFT JOIN `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
                      LEFT JOIN `sap_prospect_city` pci ON p.`city_id` = pci.`id`
                      LEFT JOIN `sap_prospect_state` pst ON p.`state_id` = pst.`id`
                      LEFT JOIN `sap_prospect_country` psc ON p.`country_id` = psc.`id`
                      LEFT JOIN `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                      WHERE   p.`id` = :id',
                            ['id' => $prospectId]
                        );

                        $data2 = [
                            'data' => [
                                'attributes' => [
                                    'stage'   => [
                                        'name' => 'Cold / Not Started'
                                    ],
                                    'address' => [
                                        'city' => $prospect['city'] ?: '',
                                        'state' => $prospect['state'] ?: '',
                                        'street' => $prospect['address'] ?: '',
                                        'zip' => $prospect['zip'] ?: ''
                                    ],
                                    'company' => [
                                        'name' => $prospect['company'] ?: '',
                                        'industry' => $prospect['industry'] ?: '',
                                    ],
                                    'contact' => [
                                        'email' => $prospect['email'],
                                        'phone' => [
                                            'personal' => $prospect['phone_personal'] ?: '',
                                            'work' => $prospect['phone_work'] ?: '',
                                        ]
                                    ],
                                    'personal' => [
                                        'name' => [
                                            'first' => $prospect['first_name'] ?: '',
                                            'last' => $prospect['last_name'] ?: ''
                                        ],
                                        'title' => $prospect['title'] ?: '',
                                    ],
                                    'metadata' => [
                                        'source' => $prospect['source'] ?: '',
                                        'tags' => [$tagName],
                                        'custom' => [
                                            $prospect['company'] ?: '',
                                            $prospect['company_revenue'] ?: ''
                                        ]
                                    ]
                                ]
                            ]
                        ];

                        $response = Sapper\Api\Outreach::call(
                            'prospects',
                            json_encode($data2, JSON_UNESCAPED_SLASHES),
                            $account['access_token'],
                            'post'
                        );

                        print("\n\n Process Request Log [upload-normalized-csv-filtered] POST: Client Id $client_id Download Id $download_id List Request Id $list_request_id Prospect email {$row['email']} Outreach Response Status {$response['status']} Prospect ID {$response['data']['data']['id']}");                           

                        if ('success' == $response['status']) {
                            $outreachId = Util::val($response, ['data', 'data', 'id']);

                            if (null !== $outreachId) {
                                $newestId = Db::insert(
                                    'INSERT INTO `sap_outreach_prospect` (`prospect_id`, `outreach_account_id`, `outreach_id`)
                                  VALUES (:prospect_id, :outreach_account_id, :outreach_id)',
                                    [
                                        'prospect_id'         => $prospectId,
                                        'outreach_account_id' => $account['id'],
                                        'outreach_id'         => $outreachId
                                    ]
                                );
                            }
                        }
                    }
                }   
            }
            
            // set dir & filenames
            $path = APP_ROOT_PATH . '/upload/' . date('Y-m-d');
            if (!is_dir($path)) {
                mkdir($path);
            }            
//            chmod($path, '0777');
            
            $filteredSuffix   = ' (Filtered).csv';
            $purgedSuffix     = ' (Purged).csv';
            
            if (!file_exists($path . '/' . $filename . $filteredSuffix)) {
                $filteredFile = $filename . $filteredSuffix;
            } else {
                $i = 1;
                while (file_exists($path . '/' . $filename . " ($i) " . $filteredSuffix)) {
                    $i++;
                }
                $filteredFile = $filename . " ($i) " . $filteredSuffix;
            }

            if (!file_exists($path . '/' . $filename . $purgedSuffix)) {
                $purgedFile = $filename . $purgedSuffix;
            } else {
                $i = 1;
                while (file_exists($path . '/' . $filename . " ($i) " . $purgedSuffix)) {
                    $i++;
                }
                $purgedFile = $filename . " ($i) " . $purgedSuffix;
            }
            
            $outputHeaders = [
                'First Name', 'Last Name', 'Email', 'Title', 'Account',
                'Company', 'Work Phone', 'Mobile Phone','Website',
                'Address', 'City', 'State', 'Zip', 'Country', 'Revenue',
                'Employees', 'Company Industry', 'Source', 'Sapper Client Segment'
            ];   
            
            if (!empty($rows_filtered)) {
                // filtered output
                $output = fopen($path . '/' . $filteredFile, 'w');
                fputcsv($output, $outputHeaders);

                foreach ($rows_filtered as $row) {
                    fputcsv(
                        $output,
                        [
                            isset($row['first_name'])     ? $row['first_name']   : '',
                            isset($row['last_name'])     ? $row['last_name']   : '',
                            isset($row['email'])     ? $row['email']   : '',
                            isset($row['title'])     ? $row['title']   : '',
                            isset($row['account'])     ? $row['account']   : '',
                            isset($row['company'])     ? $row['company']   : '',
                            isset($row['phone_work'])     ? $row['phone_work']   : '',
                            isset($row['phone_personal'])     ? $row['phone_personal']   : '',
                            isset($row['website'])     ? $row['website']   : '',
                            isset($row['address'])     ? $row['address']   : '',
                            isset($row['city'])     ? $row['city']   : '',
                            isset($row['state'])     ? $row['state']   : '',
                            isset($row['zip'])     ? $row['zip']   : '',
                            isset($row['country'])     ? $row['country']   : '',
                            isset($row['company_revenue'])     ? $row['company_revenue']   : '',
                            isset($row['company_employees'])     ? $row['company_employees']   : '',
                            isset($row['industry'])     ? $row['industry']   : '',
                            isset($row['source'])     ? $row['source']   : '',
                            $clientName
                        ]
                    );
                }
                fclose($output);  
            }
            
            if (!empty($rows_purged)) {
                // purged output
                $outputHeaders[] = 'Purged Reason';

                $output = fopen($path . '/' . $purgedFile, 'w');
                fputcsv($output, $outputHeaders);

                foreach ($rows_purged as $purgeReasonStr=>$row) {
                    $prArr = explode("_", $purgeReasonStr);
                    $purgeReason = !empty($prArr[0]) ? trim($prArr[0]) : '';
                    
                    fputcsv(
                        $output,
                        [
                            isset($row['first_name'])     ? $row['first_name']   : '',
                            isset($row['last_name'])     ? $row['last_name']   : '',
                            isset($row['email'])     ? $row['email']   : '',
                            isset($row['title'])     ? $row['title']   : '',
                            isset($row['account'])     ? $row['account']   : '',
                            isset($row['company'])     ? $row['company']   : '',
                            isset($row['phone_work'])     ? $row['phone_work']   : '',
                            isset($row['phone_personal'])     ? $row['phone_personal']   : '',
                            isset($row['website'])     ? $row['website']   : '',
                            isset($row['address'])     ? $row['address']   : '',
                            isset($row['city'])     ? $row['city']   : '',
                            isset($row['state'])     ? $row['state']   : '',
                            isset($row['zip'])     ? $row['zip']   : '',
                            isset($row['country'])     ? $row['country']   : '',
                            isset($row['company_revenue'])     ? $row['company_revenue']   : '',
                            isset($row['company_employees'])     ? $row['company_employees']   : '',
                            isset($row['industry'])     ? $row['industry']   : '',
                            isset($row['source'])     ? $row['source']   : '',
                            $clientName,
                            $purgeReason,
                        ]
                    );
                }
                fclose($output);  
            }
            
            if (!empty($rows_filtered) AND !empty($rows_purged)) {
                $id = Db::insert(
                    'INSERT INTO `sap_download`
                            (`list_request_id`, `created_on`, `filename`, `row_count`, `filtered`, `filtered_count`,
                             `purged`, `purged_count`, `saved_to_db`, `uploaded_to_outreach`)
                      VALUES (:list_request_id, :created_on, :filename, :row_count, :filtered, :filtered_count,
                              :purged, :purged_count, :saved_to_db, :uploaded_to_outreach)',
                    [
                        'list_request_id'      => $list_request_id,
                        'created_on'           => date('Y-m-d'),
                        'filename'             => $filename,
                        'row_count'            => count($total_rows),
                        'filtered'             => $filteredFile,
                        'filtered_count'       => count($rows_filtered),
                        'purged'               => $purgedFile,
                        'purged_count'         => count($rows_purged),
                        'saved_to_db'          => 1,
                        'uploaded_to_outreach' => 1
                    ]
                );             
            }

            Db::query(
                "UPDATE `sap_list_request` "
                    . "SET `uploaded_to_outreach` = 1, `status` = 'fulfilled'"
                    . "WHERE `id` = :id",
                [
                    'id' => $list_request_id,
                ]
            );            
            
            Db::query(
                'UPDATE `sap_download_filtered` SET `status` = "Complete" WHERE `id` = :id',
                ['id' => $download_id]
            );            
            
            Db::query(
                'UPDATE `sap_background_job` SET `status` = "complete" WHERE `id` = :id',
                ['id' => $job['id']]
            );
            break;
        case 'upload-normalized-csv':

            Db::query(
                'UPDATE `sap_background_job` SET `status` = "processing", `pid` = :pid WHERE `id` = :id',
                [
                    'pid' => getmypid(),
                    'id'  => $job['id']
                ]
            );

            $prospectIds = [];

            foreach(
                Db::fetchAll(
                    'SELECT * FROM `sap_download_prospect` WHERE `download_id` = :download_id',
                    ['download_id' => $data['download_id']]
                ) as $prospect
            ) {
                $prospectIds[] = $prospect['prospect_id'];
            }

            // apply prospects to Outreach account
            if (0 == count($prospectIds)) {
                killJob($job, 'no prospects to sync to outreach');
            }

            $account = Db::fetch(
                'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $data['outreach_account_id']]
            );

            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $account['client_id']],
                'name'
            );

            $tagName = $data['tag'];
            $tagId   = Util::prospectAttributeId('prospect_tag', $tagName);

            foreach ($prospectIds as $prospectId) {

                $account = Db::fetch(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                    ['id' => $data['outreach_account_id']]
                );

                $outreachProspect = Db::fetch(
                    'SELECT *
               FROM `sap_outreach_prospect`
              WHERE `prospect_id` = :prospect_id
                AND `outreach_account_id` = :outreach_account_id',
                    ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                );

                if (false !== $outreachProspect) {

                    // tag prospect
                    $tags = [$tagName];
                    foreach(
                        Db::fetchAll(
                            'SELECT t.`name`
                       FROM `sap_outreach_prospect_tag` opt
                  LEFT JOIN `sap_prospect_tag` t ON opt.`tag_id` = t.`id`
                      WHERE opt.`outreach_prospect_id` = :outreach_prospect_id',
                            ['outreach_prospect_id' => $outreachProspect['id']]
                        ) as $tag
                    ) {
                        $tags[] = $tag['name'];
                    }

                    Db::insert(
                        'INSERT INTO `sap_outreach_prospect_tag` (`outreach_prospect_id`, `tag_id`)
                      VALUES (:outreach_prospect_id, :tag_id)',
                        [
                            'outreach_prospect_id' => $outreachProspect['id'],
                            'tag_id'               => $tagId
                        ]
                    );

                    $response = Sapper\Api\Outreach::call(
                        'prospects/' . $outreachProspect['id'],
                        json_encode(['data' => ['attributes' => ['metadata' => ['tags' => []]]]]),
                        $account['access_token'],
                        'patch'
                    );

                    if (404 == $response['data']['errors'][0]['status']) {
                        Db::fetch(
                            'DELETE
                       FROM `sap_outreach_prospect`
                      WHERE `prospect_id` = :prospect_id
                        AND `outreach_account_id` = :outreach_account_id',
                            ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                        );
                        goto syncNewProspect2;
                    }

                    Sapper\Api\Outreach::call(
                        'prospects/' . $outreachProspect['id'],
                        json_encode(['data' => ['attributes' => ['metadata' => ['tags' => $tags]]]]),
                        $account['access_token'],
                        'patch'
                    );

                } else {
                    syncNewProspect2:
                    // import prospect
                    $prospect = Db::fetch(
                        'SELECT   p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                        pci.`name` AS `city`, pst.`name` AS `state`, ps.`name` AS `source`
                   FROM     `sap_prospect` p
              LEFT JOIN     `sap_prospect_company` pc ON p.`company_id` = pc.`id`
              LEFT JOIN     `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
              LEFT JOIN     `sap_prospect_city` pci ON p.`city_id` = pci.`id`
              LEFT JOIN     `sap_prospect_state` pst ON p.`state_id` = pst.`id`
              LEFT JOIN     `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                  WHERE   p.`id` = :id',
                        ['id' => $prospectId]
                    );

                    $data2 = [
                        'data' => [
                            'attributes' => [
                                'stage'   => [
                                    'name' => 'Cold / Not Started'
                                ],
                                'address' => [
                                    'city' => $prospect['city'] ?: '',
                                    'state' => $prospect['state'] ?: '',
                                    'street' => $prospect['address'] ?: '',
                                    'zip' => $prospect['zip'] ?: ''
                                ],
                                'company' => [
                                    'name' => $prospect['company'] ?: '',
                                    'industry' => $prospect['industry'] ?: '',
                                ],
                                'contact' => [
                                    'email' => $prospect['email'],
                                    'phone' => [
                                        'personal' => $prospect['phone_personal'] ?: '',
                                        'work' => $prospect['phone_work'] ?: '',
                                    ]
                                ],
                                'personal' => [
                                    'name' => [
                                        'first' => $prospect['first_name'] ?: '',
                                        'last' => $prospect['last_name'] ?: ''
                                    ],
                                    'title' => $prospect['title'] ?: '',
                                ],
                                'metadata' => [
                                    'source' => $prospect['source'] ?: '',
                                    'tags' => [$tagName],
                                    'custom' => [
                                        $prospect['company'] ?: '',
                                        $prospect['company_revenue'] ?: ''
                                    ]
                                ]
                            ]
                        ]
                    ];

                    $response = Sapper\Api\Outreach::call(
                        'prospects',
                        json_encode($data2, JSON_UNESCAPED_SLASHES),
                        $account['access_token'],
                        'post'
                    );

                    if ('success' == $response['status']) {
                        $outreachId = Util::val($response, ['data', 'data', 'id']);

                        if (null !== $outreachId) {
                            $newestId = Db::insert(
                                'INSERT INTO `sap_outreach_prospect` (`prospect_id`, `outreach_account_id`, `outreach_id`)
                              VALUES (:prospect_id, :outreach_account_id, :outreach_id)',
                                [
                                    'prospect_id'         => $prospectId,
                                    'outreach_account_id' => $account['id'],
                                    'outreach_id'         => $outreachId
                                ]
                            );
                        }
                    }
                }
            }
            
            Db::query(
                'UPDATE `sap_background_job` SET `status` = "complete" WHERE `id` = :id',
                ['id' => $job['id']]
            );

            break;

        case 'list_request':
            if (empty($data['list_request_id'])) {
                killJob($job, 'missing list request id');
            }

            if (!empty($data['filename']) && !file_exists(APP_ROOT_PATH . '/upload/' . $data['filename'])) {
                killJob($job, 'file not found');
            }

            $listRequestId = $data['list_request_id'];

            $request = Db::fetch(
                'SELECT * FROM `sap_list_request` WHERE `id` = :id',
                ['id' => $listRequestId]
            );

            if (empty($request)) {
                killJob($job, 'list request not found');
            }

            if (!in_array($request['status'], ['new', 'error']) && !array_key_exists('id', $_GET) && !isset($argv[1])) {
                killJob($job, 'request not in an executable status');
            }

            if ('new' == $request['type'] && empty($data['filename'])) {
                killJob($job, 'Request is new, but no filename defined');
            }

            Db::query(
                'UPDATE `sap_background_job` SET `status` = "processing", `pid` = :pid WHERE `id` = :id',
                [
                    'pid' => getmypid(),
                    'id'  => $job['id']
                ]
            );

            Db::query(
                'UPDATE `sap_list_request` SET `status` = "processing" WHERE `id` = :id',
                ['id' => $data['list_request_id']]
            );

            // if this is a new request, import prospects first
            $prospectIds = [];

            switch ($request['type']) {
                case 'new':
                    $params = [];
                    $requestData = json_decode($request['data'], true);

                    $params['client_id'] = Db::fetchColumn(
                        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                        ['id' => $request['outreach_account_id']],
                        'client_id'
                    );

                    if (array_key_exists('titles', $requestData) && !empty($requestData['titles'])) {
                        $params['titles'] = $requestData['titles'];
                    }

                    if (array_key_exists('departments', $requestData) && !empty($requestData['departments'])) {
                        $params['departments'] = $requestData['departments'];
                    }

                    if (array_key_exists('states', $requestData) && !empty($requestData['states'])) {
                        $params['states'] = $requestData['states'];
                    }

                    if (array_key_exists('countries', $requestData) && !empty($requestData['countries'])) {
                        $params['countries'] = $requestData['countries'];
                    }

                    if (array_key_exists('geotarget', $requestData) && !empty($requestData['geotarget'])) {
                        $params['geotarget'] = $requestData['geotarget'];
                    }

                    if (array_key_exists('radius', $requestData) && !empty($requestData['radius'])) {
                        $params['radius'] = $requestData['radius'];
                    }

                    $params['list_request_id'] = $data['list_request_id'];

                    // List Certified + Normalizer
                    try {
                        $results = Sapper\ProspectList::process(
                            APP_ROOT_PATH . '/upload/' . $data['filename'],
                            pathinfo($data['filename'], PATHINFO_FILENAME) . '.csv',
                            $params,
                            true,
                            true
                        );
                    } catch (\Exception $e) {
                        killJob($job, json_encode([$e->getMessage(),$e->getTraceAsString()], JSON_UNESCAPED_SLASHES), false);
                    }

                    $prospectIds = $results['prospect_ids'];
                    break;

                case 'recycled':
                    $prospects = Db::fetchAll(
                        'SELECT * FROM `sap_list_request_prospect` WHERE `list_request_id` = :list_request_id',
                        ['list_request_id' => $request['id']]
                    );
                    foreach ($prospects as $prospect) {
                        $prospectIds[$prospect['prospect_id']] = true;
                    }
                    break;
            }

            // apply prospects to Outreach account
            if (0 == count($prospectIds)) {
                killJob($job, 'no prospects to sync to outreach');
            }

            $account = Db::fetch(
                'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $request['outreach_account_id']]
            );

            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $account['client_id']],
                'name'
            );

            $tagName = $request['title'];
            $tagId   = Util::prospectAttributeId('prospect_tag', $tagName);

            $mongoDatabase = \Sapper\CosmosDb::getDatabase();

            foreach ($prospectIds as $prospectId => $link) {

                if (false == $link) {
                    continue;
                }

                $account = Db::fetch(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                    ['id' => $request['outreach_account_id']]
                );

                $outreachProspect = Db::fetch(
                    'SELECT *
               FROM `sap_outreach_prospect`
              WHERE `prospect_id` = :prospect_id
                AND `outreach_account_id` = :outreach_account_id',
                    ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                );

                if (false !== $outreachProspect) {

                    // tag prospect
                    $tags = [$tagName];
                    foreach(
                        Db::fetchAll(
                            'SELECT t.`name`
                       FROM `sap_outreach_prospect_tag` opt
                  LEFT JOIN `sap_prospect_tag` t ON opt.`tag_id` = t.`id`
                      WHERE opt.`outreach_prospect_id` = :outreach_prospect_id',
                            ['outreach_prospect_id' => $outreachProspect['id']]
                        ) as $tag
                    ) {
                        $tags[] = $tag['name'];
                    }

                    Db::insert(
                        'INSERT INTO `sap_outreach_prospect_tag` (`outreach_prospect_id`, `tag_id`)
                      VALUES (:outreach_prospect_id, :tag_id)',
                        [
                            'outreach_prospect_id' => $outreachProspect['id'],
                            'tag_id'               => $tagId
                        ]
                    );

                    $response = Sapper\Api\Outreach::call(
                        'prospects/' . $outreachProspect['id'],
                        json_encode(['data' => ['attributes' => ['metadata' => ['tags' => []]]]]),
                        $account['access_token'],
                        'patch'
                    );

                    if (404 == $response['data']['errors'][0]['status']) {
                        Db::fetch(
                            'DELETE
                       FROM `sap_outreach_prospect`
                      WHERE `prospect_id` = :prospect_id
                        AND `outreach_account_id` = :outreach_account_id',
                            ['prospect_id' => $prospectId, 'outreach_account_id' => $account['id']]
                        );
                        goto syncNewProspect;
                    }

                    Sapper\Api\Outreach::call(
                        'prospects/' . $outreachProspect['id'],
                        json_encode(['data' => ['attributes' => ['metadata' => ['tags' => $tags]]]]),
                        $account['access_token'],
                        'patch'
                    );

                } else {
                    syncNewProspect:
                    // import prospect
                    $prospect = Db::fetch(
                        'SELECT   p.*, pc.`name` AS `company`, pi.`name` AS `industry`,
                        pci.`name` AS `city`, pst.`name` AS `state`, ps.`name` AS `source`
                   FROM     `sap_prospect` p
              LEFT JOIN     `sap_prospect_company` pc ON p.`company_id` = pc.`id`
              LEFT JOIN     `sap_prospect_industry` pi ON p.`industry_id` = pi.`id`
              LEFT JOIN     `sap_prospect_city` pci ON p.`city_id` = pci.`id`
              LEFT JOIN     `sap_prospect_state` pst ON p.`state_id` = pst.`id`
              LEFT JOIN     `sap_prospect_source` ps ON p.`source_id` = ps.`id`
                  WHERE   p.`id` = :id',
                        ['id' => $prospectId]
                    );

                    $data = [
                        'data' => [
                            'attributes' => [
                                'stage'   => [
                                    'name' => 'Cold / Not Started'
                                ],
                                'address' => [
                                    'city' => $prospect['city'] ?: '',
                                    'state' => $prospect['state'] ?: '',
                                    'street' => $prospect['address'] ?: '',
                                    'zip' => $prospect['zip'] ?: ''
                                ],
                                'company' => [
                                    'name' => $prospect['company'] ?: '',
                                    'industry' => $prospect['industry'] ?: '',
                                ],
                                'contact' => [
                                    'email' => $prospect['email'],
                                    'phone' => [
                                        'personal' => $prospect['phone_personal'] ?: '',
                                        'work' => $prospect['phone_work'] ?: '',
                                    ]
                                ],
                                'personal' => [
                                    'name' => [
                                        'first' => $prospect['first_name'] ?: '',
                                        'last' => $prospect['last_name'] ?: ''
                                    ],
                                    'title' => $prospect['title'] ?: '',
                                ],
                                'metadata' => [
                                    'source' => $prospect['source'] ?: '',
                                    'tags' => [$tagName],
                                    'custom' => [
                                        $prospect['company'] ?: '',
                                        $prospect['company_revenue'] ?: ''
                                    ]
                                ]
                            ]
                        ]
                    ];

                    // API v1 push
                    $response = Sapper\Api\Outreach::call(
                        'prospects',
                        json_encode($data, JSON_UNESCAPED_SLASHES),
                        $account['access_token'],
                        'post'
                    );

                    // API v2 push

                    // find user
                    /*$ownerId  = null;
                    $response = Sapper\Api\Outreach::call(
                        'users',
                        ['filter[email]' => $account['email']],
                        $account['access_token'],
                        'get',
                        \Sapper\Api\Outreach::URL_REST_v2
                    );

                    if ('success' == $response['status'] && count($response['data']['data'])) {
                        $ownerId = $response['data']['data'][0]['id'];
                    }
                    
                    // find stage
                    $response = Sapper\Api\Outreach::call(
                        'stages',
                        ['filter[name]' => 'Cold / Not Started'],
                        $account['access_token'],
                        'get',
                        \Sapper\Api\Outreach::URL_REST_v2
                    );

                    if ('success' == $response['status']) {

                        // create stage if it doesn't exist
                        if (0 == count($response['data']['data'])) {
                            $response = Sapper\Api\Outreach::call(
                                'stages',
                                json_encode([
                                    'data' => [
                                        'type' => 'stage',
                                        'attributes' => [
                                            'name' => 'Cold / Not Started'
                                        ]
                                    ]
                                ], JSON_UNESCAPED_SLASHES),
                                $account['access_token'],
                                'post',
                                \Sapper\Api\Outreach::URL_REST_v2
                            );
                            
                            if ('success' == $response['status']) {
                                $stageData = $response['data']['data'];
                                $stageId   = $response['data']['data']['id'];
                            }
                            
                        } else {
                            $stageData = $response['data']['data'][0];
                            $stageId   = $response['data']['data'][0]['id'];
                        }
                    }

                    // find account (aka Company)
                    $company  = $prospect['company'];
                    $industry = $prospect['industry'];

                    $response = Sapper\Api\Outreach::call(
                        'accounts',
                        ['filter[name]' => $company],
                        $account['access_token'],
                        'get',
                        \Sapper\Api\Outreach::URL_REST_v2
                    );

                    if ('success' == $response['status']) {

                        // create account if it doesn't exist
                        if (0 == count($response['data']['data'])) {
                            $response = Sapper\Api\Outreach::call(
                                'accounts',
                                json_encode([
                                    'data' => [
                                        'type' => 'account',
                                        'attributes' => [
                                            'name' => $company,
                                            'industry' => $industry
                                        ],
                                        'relationships' => [
                                            'owner' => [
                                                'data' => [
                                                    'type' => 'user',
                                                    'id'   => $ownerId
                                                ]
                                            ]
                                        ]
                                    ]
                                ], JSON_UNESCAPED_SLASHES),
                                $account['access_token'],
                                'post',
                                \Sapper\Api\Outreach::URL_REST_v2
                            );

                            if ('success' == $response['status']) {
                                $companyData = $response['data']['data'];
                                $companyId   = $response['data']['data']['id'];
                            }

                        } else {
                            $companyData = $response['data']['data'][0];
                            $companyId   = $response['data']['data'][0]['id'];
                        }
                    }

                    $response = Sapper\Api\Outreach::call(
                        'prospects',
                        json_encode([
                            'data' => [
                                'type'       => 'prospect',
                                'attributes' => [
                                    'addressCity' => $prospect['city'] ?: null,
                                    'addressState' => $prospect['state'] ?: null,
                                    'addressStreet' => $prospect['address'] ?: null,
                                    'addressZip' => $prospect['zip'] ?: null,
                                    'custom1' => $prospect['company'] ?: null,
                                    'emails' => [$prospect['email']],
                                    'firstName' => $prospect['first_name'] ?: null,
                                    'lastName' => $prospect['last_name'] ?: null,
                                    'source' => $prospect['source'] ?: null,
                                    'tags' => [$tagName],
                                    'title' => $prospect['title'] ?: null,
                                    'workPhones' => [
                                        $prospect['phone_work'] ?: null,
                                        $prospect['phone_personal'] ?: null
                                    ]
                                ],
                                'relationships' => [
                                    'owner' => [
                                        'data' => [
                                            'type' => 'user',
                                            'id'   => $ownerId
                                        ]
                                    ],
                                    'account' => [
                                        'data' => [
                                            'type' => 'account',
                                            'id'   => $companyId
                                        ]
                                    ],
                                    'stage' => [
                                        'data' => [
                                            'type' => 'stage',
                                            'id'   => $stageId
                                        ]
                                    ]
                                ]
                            ]
                        ], JSON_UNESCAPED_SLASHES),
                        $account['access_token'],
                        'post',
                        \Sapper\Api\Outreach::URL_REST_v2
                    );

                    if ('success' == $response['status']) {
                        $prospectData = $response['data']['data'];
                        $prospectId   = $response['data']['data']['id'];
                    }

                    $client = Db::fetchById('sap_client', $account['client_id']);

                    // push account, stage, prospect to CosmosDb
                    $sapperData = [
                        'client_id'   => $client['id'],
                        'client_name' => $client['name'],
                        'outreach_account_id'    => $account['id'],
                        'outreach_account_email' => $account['email']
                    ];

                    foreach ([
                        'account'  => ['id' => $companyId,  'data' => $companyData],
                        'stage'    => ['id' => $stageId,    'data' => $stageData],
                        'prospect' => ['id' => $prospectId, 'data' => $prospectData]
                     ] as $entityName => $entity) {

                        $mongoCollection = $mongoDatabase->selectCollection('outreach-' .$entityName);

                        \Sapper\CosmosDb::mongoCall(
                            $mongoCollection,
                            'findOneAndReplace',
                            [
                                [
                                    'id'               => $entity['id'],
                                    'sapper.shard_key' => $account['id']
                                ],
                                $entity['data'],
                                ['upsert' => true]
                            ]
                        );
                    }

                    */

                    if (!isset($responses)) {
                        $responses = [];
                    }
                    $responses[] = $response;

                    if ('success' == $response['status']) {
                        $outreachId = Util::val($response, ['data', 'data', 'id']);

                        if (null !== $outreachId && true == $link) {
                            $newestId = Db::insert(
                                'INSERT INTO `sap_outreach_prospect` (`prospect_id`, `outreach_account_id`, `outreach_id`)
                              VALUES (:prospect_id, :outreach_account_id, :outreach_id)',
                                [
                                    'prospect_id'         => $prospectId,
                                    'outreach_account_id' => $account['id'],
                                    'outreach_id'         => $outreachId
                                ]
                            );
                            $responses[] = $newestId;
                        }
                    }
                }
            }
            Db::query(
                'UPDATE `sap_background_job` SET `status` = "complete" WHERE `id` = :id',
                ['id' => $job['id']]
            );

            Db::query(
                'UPDATE `sap_list_request` SET `status` = "fulfilled" WHERE `id` = :id',
                ['id' => $listRequestId]
            );
            break;
    }
}
} catch (Exception $exc) {
    killJob($job, $exc->getMessage());    
}


function killJob($job, $error = null, $autoRetry = false) {


    if ($autoRetry) {
        Db::query(
            'UPDATE `sap_background_job` SET `status` = "ready" WHERE `id` = :id',
            [
                'id' => $job['id']
            ]
        );

        $data = json_decode($job['data'], true);

        if (!empty($data['list_request_id'])) {
            Db::query(
                'UPDATE `sap_list_request` SET `status` = "new" WHERE `id` = :id',
                [
                    'id'    => $data['list_request_id']
                ]
            );
        }

        exit;
    } else {
        Db::query(
            'UPDATE `sap_background_job` SET `status` = "error", `error` = :error WHERE `id` = :id',
            [
                'error' => $error,
                'id'    => $job['id']
            ]
        );

        $data = json_decode($job['data'], true);

        if (!empty($data['list_request_id'])) {
            Db::query(
                'UPDATE `sap_list_request` SET `status` = "error", `error` = :error WHERE `id` = :id',
                [
                    'error' => $error,
                    'id'    => $data['list_request_id']
                ]
            );
        }

        throw new Exception($error);
    }
}
