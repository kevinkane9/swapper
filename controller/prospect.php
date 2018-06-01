<?php

use Sapper\Route,
    Sapper\Db,
    Sapper\Util;

switch (Route::uriParam('action')) {
    case 'edit':
        $prospectId = Route::uriParam('prospectId');
        $prospect   = Db::fetch(
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

        $outreachProspects = Db::fetchAll(
            'SELECT  op.*, cao.`email` AS `outreach_account_email`, c.`name` as `client_name`
               FROM `sap_outreach_prospect` op
          LEFT JOIN `sap_client_account_outreach` cao ON op.`outreach_account_id` = cao.`id`
          LEFT JOIN `sap_client` c ON c.`id` = cao.`client_id`
              WHERE  op.`prospect_id` = :prospect_id',
            ['prospect_id' => $prospectId]
        );

        foreach ($outreachProspects as $i => $outreachProspect) {
            $outreachProspects[$i]['tags'] = Db::fetchAll(
                'SELECT  opt.*, pt.`name`
                   FROM `sap_outreach_prospect_tag` opt
              LEFT JOIN `sap_prospect_tag` pt ON opt.`tag_id` = pt.`id`
                  WHERE `outreach_prospect_id` = :outreach_prospect_id',
                ['outreach_prospect_id' => $outreachProspect['id']]
            );
        }

        $sources = Db::fetchAll('SELECT * FROM `sap_prospect_source`');

        sapperView(
            'prospect',
            [
                'prospect'          => $prospect,
                'outreachProspects' => $outreachProspects,
                'sources'           => $sources
            ]
        );
        break;

    case 'save':
        $prospectId = Route::uriParam('prospectId');
        $prospect   = Db::fetch('SELECT * FROM `sap_prospect` WHERE `id` = :id', ['id' => $prospectId]);

        // company id
        if (!empty($_POST['company'])) {
            $companyId = Db::fetchColumn('SELECT * FROM `sap_prospect_company` WHERE `name` = :name', ['name' => $_POST['company']], 'id');

            if (null == $companyId) {
                $companyId = Db::insert('INSERT INTO `sap_prospect_company` (`name`) VALUES (:name)', ['name' => $_POST['company']]);
            }
        } else {
            $companyId = null;
        }

        // industry id
        if (!empty($_POST['industry'])) {
            $industryId = Db::fetchColumn('SELECT * FROM `sap_prospect_industry` WHERE `name` = :name', ['name' => $_POST['industry']], 'id');

            if (null == $industryId) {
                $industryId = Db::insert('INSERT INTO `sap_prospect_industry` (`name`) VALUES (:name)', ['name' => $_POST['industry']]);
            }
        } else {
            $industryId = null;
        }

        // city id
        if (!empty($_POST['city'])) {
            $cityId = Db::fetchColumn('SELECT * FROM `sap_prospect_city` WHERE `name` = :name', ['name' => $_POST['city']], 'id');

            if (null == $cityId) {
                $cityId = Db::insert('INSERT INTO `sap_prospect_city` (`name`) VALUES (:name)', ['name' => $_POST['city']]);
            }
        } else {
            $cityId = null;
        }

        // state id
        if (!empty($_POST['company'])) {
            $stateId = Db::fetchColumn('SELECT * FROM `sap_prospect_state` WHERE `name` = :name', ['name' => $_POST['state']], 'id');

            if (null == $stateId) {
                $stateId = Db::insert('INSERT INTO `sap_prospect_state` (`name`) VALUES (:name)', ['name' => $_POST['state']]);
            }
        } else {
            $stateId = null;
        }

        if (!empty($_POST['state'])) {
            $location = ['state' => $_POST['state']];

            if (!empty($_POST['city'])) {
                $location['city'] = $_POST['city'];
            }

            $geocode = Sapper\Api\Geocode::convert(([$location]));

            if (true == $geocode[0]['geolocated']) {
                $lat = $geocode[0]['lat'];
                $lng = $geocode[0]['lng'];
            } else {
                $lat = null;
                $lng = null;
            }
        } else {
            $lat = null;
            $lng = null;
        }

        try {
            Db::query(
                'UPDATE `sap_prospect`
                    SET `email` = :email, `first_name` = :first_name, `last_name` = :last_name,
                        `title` = :title, `company_id` = :company_id, `company_revenue` = :company_revenue,
                        `industry_id` = :industry_id, `company_employees` = :company_employees, `address` = :address,
                        `address2` = :address2, `city_id` = :city_id, `state_id` = :state_id, `zip` = :zip,
                        `lat` = :lat, `lng` = :lng, `phone_work` = :phone_work, `phone_personal` = :phone_personal,
                        `source_id` = :source_id
                  WHERE `id` = :id',
                [
                    'email'       => $_POST['email'], 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'],
                    'title'       => $_POST['title'], 'company_id' => $companyId, 'company_revenue' => $_POST['company_revenue'],
                    'industry_id' => $industryId, 'company_employees' => $_POST['company_employees'],
                    'address'     => $_POST['address'], 'address2' => $_POST['address2'], 'city_id' => $cityId,
                    'state_id'    => $stateId, 'zip' => (string) $_POST['zip'], 'lat' => $lat, 'lng' => $lng,
                    'phone_work'  => $_POST['phone_work'], 'phone_personal' => $_POST['phone_personal'],
                    'source_id'   => $_POST['source_id'], 'id' => $prospectId
                ]
            );
        } catch (Exception $e) {
            if (false !== strpos($e->getMessage(), 'Duplicate')) {
                Route::setFlash('danger', 'Email address already in use');
            } else {
                Route::setFlash('danger', $e->getMessage());
            }

            header('Location: /prospect/edit/' . $prospectId);
            exit;
        }

        foreach ($_POST['outreachProspect'] as $accountId => $data) {
            $errors  = [];
            $account = Db::fetch(
                'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
                ['id' => $accountId]
            );

            if (!empty($account['access_token']) && 'disconnected' !== $account['status']) {
                $outreachProspect = Db::fetch(
                    'SELECT *
                   FROM `sap_outreach_prospect`
                  WHERE `prospect_id` = :prospect_id AND `outreach_account_id` = :outreach_account_id',
                    [
                        'prospect_id'         => $prospectId,
                        'outreach_account_id' => $accountId
                    ]
                );

                $tags = [];

                foreach ($data['tagIds'] as $tagId) {
                    if (0 === strpos($tagId, '!')) {

                        // check if tag exists at all (previously we checked only tags from this client
                        $dbTagId = Db::fetchColumn(
                            'SELECT * FROM `sap_prospect_tag` WHERE `name` = :name',
                            ['name' => substr($tagId, 1)],
                            'id'
                        );


                        if (null == $dbTagId) {
                            $dbTagId = Db::insert(
                                'INSERT INTO `sap_prospect_tag` (`name`) VALUES (:name)', ['name' => substr($tagId, 1)]
                            );
                        }

                        $tags[$dbTagId] = substr($tagId, 1);
                    } else {
                        $tag = Db::fetch('SELECT * FROM `sap_prospect_tag` WHERE `id` = :id', ['id' => $tagId]);

                        $tags[$tag['id']] = $tag['name'];
                    }
                }

                // update DB
                Db::query(
                    'DELETE FROM `sap_outreach_prospect_tag` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                    ['outreach_prospect_id' => $outreachProspect['id']]
                );

                foreach (array_keys($tags) as $tagId) {
                    Db::insert(
                        'INSERT INTO `sap_outreach_prospect_tag` (`outreach_prospect_id`, `tag_id`)
                              VALUES (:outreach_prospect_id, :tag_id)',
                        [
                            'outreach_prospect_id' => $outreachProspect['id'],
                            'tag_id'               => $tagId
                        ]
                    );
                }
                
                // update outreach
                $source = Db::fetchColumn(
                    'SELECT * FROM `sap_prospect_source` WHERE `id` = :id',
                    ['id' => $_POST['source_id']],
                    'name'
                );

                // remove tags
                $response = Sapper\Api\Outreach::call(
                    'prospects/' . $outreachProspect['outreach_id'],
                    json_encode(['data' => ['attributes' => ['metadata' => ['tags' => []]]]]),
                    $account['access_token'],
                    'patch'
                );

                // update data
                $data = [
                    'data' => [
                        'attributes'  => [
                            'address' => [
                                'city'   => $_POST['city'],
                                'state'  => $_POST['state'],
                                'street' => [$_POST['address'], $_POST['address2']],
                                'zip'    => (string) $_POST['zip']
                            ],
                            'company' => [
                                'name'     => $_POST['company'],
                                'industry' => $_POST['industry'],
                            ],
                            'contact' => [
                                'phone' => [
                                    'personal' => $_POST['phone_personal'],
                                    'work'     => $_POST['phone_work'],
                                ]
                            ],
                            'personal' => [
                                'name' => [
                                    'first' => $_POST['first_name'],
                                    'last'  => $_POST['last_name']
                                ],
                                'title' => $_POST['title'],
                            ],
                            'metadata' => [
                                'source' => $source,
                                'tags'   => array_values($tags),
                                'custom' => [
                                    $_POST['company'],
                                    $_POST['company_revenue']
                                ]
                            ]
                        ]
                    ]
                ];

                if ($_POST['email'] !== $prospect['email']) {
                    $data['data']['attributes']['contact']['email'] = $_POST['email'];
                }

                $response = Sapper\Api\Outreach::call(
                    'prospects/' . $outreachProspect['outreach_id'],
                    json_encode($data, JSON_UNESCAPED_SLASHES),
                    $account['access_token'],
                    'patch'
                );

                if ($error = Util::val($response, ['data', 'errors', 0, 'detail'])) {
                    foreach ($error as $errorMsg) {
                        $errors[] = $errorMsg[0];
                    }
                }
            }
        }

        if (0 == count($errors)) {
            Route::setFlash('success', 'Prospect successfully updated');
        } else {
            Route::setFlash('danger', implode('<br>', $errors));
        }

        header('Location: /prospect/edit/' . $prospectId);
        break;

    case 'find-tag':
        $tags = Db::fetchAll(
            'SELECT  pt.`id`, pt.`name` AS `text`
               FROM `sap_prospect_tag` pt
          LEFT JOIN `sap_outreach_prospect_tag` opt ON opt.`tag_id` = pt.`id`
          LEFT JOIN `sap_outreach_prospect` op ON op.`id` = opt.`outreach_prospect_id`
              WHERE  pt.`name` LIKE :term
                AND  op.`outreach_account_id` = :outreach_account_id
           GROUP BY  pt.`id`',
            [
                'term'                => '%' . $_POST['term'] . '%',
                'outreach_account_id' => $_POST['outreachAccountId']
            ]
        );
        jsonSuccess($tags);
        break;

    default:
        throw new Exception('Unknown action');
        break;
}