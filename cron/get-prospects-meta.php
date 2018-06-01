<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Api\Outreach;
use Sapper\Db;
use Sapper\Model;
use Sapper\Settings;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

Util::addLog("Sync Prospects - : Syncing script begin.");

// outreach accounts
if (isset($accountId)) {
    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_outreach` WHERE `status` = "connected" AND `id` = :id',
        ['id' => $accountId]
    );
} else {
    
    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status` = "syncing" AND `under_process_by` = "' . basename(__FILE__, '.php') . '"');

    if ($count['count'] >= 15) {
        echo 'Max # of syncs already in progress';
        exit;
    }

    $account = Db::fetch(
        'SELECT  *
           FROM `sap_client_account_outreach`
          WHERE `status` = "connected"
            AND (`last_pulled_at` IS NULL OR `last_pulled_at` < :one_hour_ago)
       ORDER BY `sync_stage_prospects_updated_at` ASC',
        ['one_hour_ago' => date('Y-m-d H:i:s', time() - (7200))]
    );
}

if (empty($account)) {
    exit;
}

$accountId = $account['id'];

Db::query(
    'UPDATE `sap_client_account_outreach` SET `status` = "syncing", `under_process_by` = "' . basename(__FILE__, '.php') . '" WHERE `id` = :id',
    ['id' => $accountId]
);

Util::addLog("Sync Prospects - : Syncing started for outreach account $accountId.");

// sync prospects
$page               = !empty($account['sync_stage_prospects_last_page']) ? ($account['sync_stage_prospects_last_page']) : 1;
$prospectsRemaining = false;
$geocodes           = [];
$params             = [];
$externalIds        = [];

if (null !== $account['last_pulled_at']) {
    $sync_stage_prospects_updated_at = strtotime($account['sync_stage_prospects_updated_at']);
    $params['filter[metadata/updated/after]'] = date('Y-m-d', $sync_stage_prospects_updated_at) . 'T' . date('H:i:s', $sync_stage_prospects_updated_at) . '.000Z';
}

$exe_count=0;
do {
    $params['page[number]'] = $page;

    // re-fetch account in case access token has been refreshed since last API query
    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
        ['id' => $accountId]
    );

    $prospects = Outreach::call(
        'prospects',
        $params,
        $account['access_token'],
        'get'
    );

    $prospect_res = [];

    $outreachCreatedAt='';
    $outreachUpdatedAt='';
    $outreachOptedOutAt='';
    if ('success' == $prospects['status'] AND !empty($prospects['data']['meta']['results']['total']) AND count($prospects['data']['data']) > 0) {
        Util::addLog("Sync Prospects - : downloaded ".count($prospects['data']['data'])." prospects for outreach account $accountId via API v1.");
        foreach ($prospects['data']['data'] as $prospectData) {
            Util::addLog("Sync Prospects - : Iterating prospect id ".$prospectData['id']." from API v1.");
            $prospect_res = Outreach::call(
                'prospects/' . $prospectData['id'],
                [],
                $account['access_token'],
                'get',
                Outreach::URL_REST_v2
            );
			           
            try {
                $exe_count++;
                
                if (!empty($prospect_res) AND !empty($prospect_res['data']['data']) AND 'success' == $prospect_res['status']){
                    $prospect_details = $prospect_res['data']['data'];

                    $outreachCreatedAt = !empty($prospect_details['attributes']['createdAt']) ? $prospect_details['attributes']['createdAt'] : '';
                    $outreachUpdatedAt = !empty($prospect_details['attributes']['updatedAt']) ? $prospect_details['attributes']['updatedAt'] : '';
                    $outreachOptedOutAt = !empty($prospect_details['attributes']['updatedAt']) ? $prospect_details['attributes']['optedOutAt'] : '';
                    

                    Util::addLog("Sync Prospects - : Pulled prospect id ".$prospect_details['id']." from API v2.");
                } else {
                    
                    if (!empty($prospect_res['status']) AND 'error' == $prospect_res['status']) {
                        
                        $api_errors = json_decode($prospect_res['error'], true);

                        $api_error = $api_errors['errors'][0];

                        if (!empty($api_error['id']) AND $api_error['id'] == 'rateLimitExceeded') {
                            Db::query(
                                "UPDATE `sap_client_account_outreach` "
                                    . "SET `sync_stage_prospects_last_page` = '{$page}', "
                                    . "`sync_stage_prospects_updated_at` = NOW(), "
                                    . "`status` = 'connected', "
                                    . "`last_pulled_at` = NOW(), "
                                    . "`under_process_by` = '' "
                                    . "WHERE `id` = :id",
                                ['id' => $account['id']]
                            );                          
                                
                            Util::addLog("Sync Prospects - API v2 Outreach Account Id : {$account['id']} - Server Message:  " . $api_error['detail']);
                            exit();
                        }
                    } else {
                        print_r($prospect_res);
                    }

                    Util::addLog("Sync Prospects - Prospect ID {$prospectData['id']} not pulled from API v2. Error : " . $prospect_res['error']);
                }

            } catch (Exception $e) {
                Util::addLog('Sync Prospects - Exception 1: ' . $e->getMessage());
            }
            

            if (!empty($prospect_res['status']) AND 'success' == $prospect_res['status']) {

                $email = Util::val($prospectData, ['data', 'data', 'attributes', 'contact', 'email']);

                if (null == $email || '' == $email) {
                    continue;
                }

                $companyId = Util::prospectAttributeId(
                    'prospect_company',
                    Util::val($prospectData, ['data', 'data', 'attributes', 'company', 'name'])
                );

//                $industryId = Util::prospectAttributeId(
//                    'prospect_industry',
//                    Util::val($prospect, ['data', 'data', 'attributes', 'company', 'industry'])
//                );

                $cityId = Util::prospectAttributeId(
                    'prospect_city',
                    Util::val($prospect_res, ['data', 'data', 'attributes', 'addressCity'])
                );

                $state     = Util::val($prospect_res, ['data', 'data', 'attributes', 'addressState']);
                $states    = Model::get('states');
                $stateCode = (2 == strlen($state)) ? $state : array_search(trim($state), $states);

                $stateId = Util::prospectAttributeId('prospect_state', $stateCode);

                $countryId = Util::prospectAttributeId(
                    'prospect_country',
                    Util::val($prospect_res, ['data', 'data', 'attributes', 'addressCountry'])
                );

                $sourceId = Util::prospectAttributeId(
                    'prospect_source',
                    Util::val($prospect_res, ['data', 'data', 'attributes', 'source'])
                );

                $stageIds = [];
                $stages   = Util::val($prospectData, ['data', 'data', 'attributes', 'stage']);

                if (is_string($stages)) {
                    $stages = [$stages];
                }
                if (is_array($stages)) {
                    foreach ($stages as $stage) {
                        $stageId = Util::prospectAttributeId('prospect_stage', $stage);
                        if (!is_null($stageId)) {
                            $stageIds[] = $stageId;
                        }
                    }
                }

                
                $stageIdsV2 = [];
                if (!empty($prospect_details)) {
                    try {
                        $stagesV2   = Util::val($prospect_details, ['relationships', 'stage']);

                        if (!empty($stagesV2)) {
                            foreach ($stagesV2 as $stagev2) {
                                if (!empty($stagev2)) {
                                    if ($stagev2['type'] == 'stage') {
                                        $stageIdsV2[] = $stagev2['id'];
                                    }
                                }
                            }
                        } else {
                            Util::addLog("Sync Prospects - : No stages for prospect id ".$prospect_details['id']." from API v2.");
                        }
                    } catch (Exception $e) {
                        Util::addLog('Sync Prospects - Exception 2: ' . $e->getMessage());
                    }
                } else {
                    Util::addLog("Sync Prospects - Prospect ID {$prospectData['id']} not pulled from API v2.");
                }
                
                
                
                $tagIds = [];
                $tags   = Util::val($prospectData, ['data', 'data', 'attributes', 'metadata', 'tags']);

                if (is_string($tags)) {
                    $tags = [$tags];
                }

                if (is_array($tags)) {
                    foreach ($tags as $tag) {
                        $tagId = Util::prospectAttributeId('prospect_tag', $tag);
                        if (!is_null($tagId)) {
                            $tagIds[] = $tagId;
                        }
                    }
                }

                $prospectId = Db::fetchColumn(
                    'SELECT `id` FROM `sap_prospect` WHERE `email` = :email',
                    ['email' => Util::val($prospectData, ['attributes', 'contact', 'email'])],
                    'id'
                );

                $existingProspect = false;
                if (is_int($prospectId) && $prospectId > 0) {
                    $existingProspect = true;

                    Db::query(
                        'UPDATE `sap_prospect`
                                SET `first_name` = :first_name, `last_name` = :last_name, `title` = :title,
                                `company_id` = :company_id, `company_revenue` = :company_revenue, `industry_id` = :industry_id,
                                `company_employees` = :company_employees, `address` = :address, `address2` = :address2,
                                `city_id` = :city_id, `state_id` = :state_id, `zip` = :zip, `country_id` = :country_id,
                                `phone_work` = :phone_work, `phone_personal` = :phone_personal, `source_id` = :source_id,
                                `opted_out` = :opted_out,`outreach_created_at` = :outreach_created_at,
                                `outreach_updated_at` = :outreach_updated_at,`outreach_optedout_at` = :outreach_optedout_at 
                              WHERE `id` = :id',
                        [
                            'first_name'        => Util::val($prospectData, ['attributes', 'personal', 'name', 'first']),
                            'last_name'         => Util::val($prospectData, ['attributes', 'personal', 'name', 'last']),
                            'title'             => Util::val($prospectData, ['attributes', 'personal', 'title']),
                            'company_id'        => $companyId,
                            'company_revenue'   => Util::val($prospectData, ['attributes', 'metadata', 'custom', 1]),
                            //'industry_id'       => $industryId, ## Commented because not available in v2 API
                            //'company_employees' => Util::val($prospect_details, ['attributes', 'company', 'size']), ## Commented because not available in v2 API
                            'address'           => Util::val($prospect_details, ['attributes', 'addressStreet']),
                            'address2'          => Util::val($prospect_details, ['attributes', 'addressStreet2']),
                            'city_id'           => $cityId,
                            'state_id'          => $stateId,
                            'zip'               => Util::val($prospect_details, ['attributes', 'addressZip']),
                            'country_id'        => $countryId,
                            'phone_work'        => Util::val($prospectData, ['attributes', 'contact', 'phone', 'work']),
                            'phone_personal'    => Util::val($prospectData, ['attributes', 'contact', 'phone', 'personal']),
                            'source_id'         => $sourceId,
                            'opted_out'         => Util::val($prospectData, ['attributes', 'metadata', 'opted_out']) ?: 0,
                            'id'                => $prospectId,
                            'outreach_created_at' => $outreachCreatedAt,
                            'outreach_updated_at' => $outreachUpdatedAt,
                            'outreach_optedout_at' => $outreachOptedOutAt,
                        ]
                    );
                } else {
                    
                }

                $city  = Util::val($prospect_res, ['data', 'data', 'attributes', 'addressCity']);
                $state = Util::val($prospect_res, ['data', 'data', 'attributes', 'addressState']);

                if (!empty($city) && !empty($state) && false == $existingProspect) {
                    $geocodes[] = ['prospect_id' => $prospectId, 'city' => $city, 'state' => $state];
                }
                if (100 == count($geocodes)&&  1 == Settings::get('geo-encoding')) {
                    processGeocode($geocodes);
                    $geocodes = [];
                }

                if (!empty($prospectId)) {
                    $outreachProspectId = Db::fetchColumn(
                        'SELECT `id` FROM `sap_outreach_prospect` WHERE `outreach_account_id` = :outreach_account_id AND `prospect_id` = :prospect_id',
                        ['outreach_account_id' => $account['id'], 'prospect_id' => $prospectId],
                        'id'
                    );

                    $externalId = Util::val($prospect_details, ['data', 'data', 'id']);

                    if (false == $outreachProspectId) {
                        try {
                            $outreachProspectId = Db::insert(
                                'INSERT INTO `sap_outreach_prospect`
                                (`outreach_account_id`, 
                                `prospect_id`, 
                                `outreach_id`, 
                                `outreach_created_at`, 
                                `outreach_updated_at`, 
                                `outreach_optedout_at`)
                             VALUES
                              (
                                :outreach_account_id, 
                                :prospect_id, 
                                :outreach_id, 
                                :outreach_created_at, 
                                :outreach_updated_at, 
                                :outreach_optedout_at)',
                                [
                                    'outreach_account_id' => $account['id'],
                                    'prospect_id'         => $prospectId,
                                    'outreach_id'         => $externalId,
                                    'outreach_created_at' => $outreachCreatedAt,
                                    'outreach_updated_at' => $outreachUpdatedAt,
                                    'outreach_optedout_at' => $outreachOptedOutAt,                                
                                ]
                            );
                        } catch (Exception $e) {
                            throwException($e, $account);
                        }
                    } else {
                        try {
                            Db::query(
                                'UPDATE `sap_outreach_prospect`
                                    SET `outreach_created_at` = :outreach_created_at, 
                                    `outreach_updated_at` = :outreach_updated_at, 
                                    `outreach_optedout_at` = :outreach_optedout_at
                                  WHERE `id` = :id',
                                [
                                    'outreach_created_at' => $outreachCreatedAt,
                                    'outreach_updated_at' => $outreachUpdatedAt,
                                    'outreach_optedout_at' => $outreachOptedOutAt,
                                    'id' => $outreachProspectId
                                ]
                            );
                        } catch (Exception $exc) {
                            Util::addLog('Sync Prospects - Exception 4: ' . $e->getMessage());
                        }
                    }

                    Db::query(
                        'DELETE FROM `sap_outreach_prospect_tag` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                        ['outreach_prospect_id' => $outreachProspectId]
                    );

                    foreach ($tagIds as $tagId) {
                        Db::insert(
                            'INSERT INTO `sap_outreach_prospect_tag`
                              (`outreach_prospect_id`, `tag_id`)
                             VALUES
                              (:outreach_prospect_id, :tag_id)',
                            [
                                'outreach_prospect_id' => $outreachProspectId,
                                'tag_id'               => $tagId
                            ]
                        );
                    }

                    Db::query(
                        'DELETE FROM `sap_outreach_prospect_stage` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                        ['outreach_prospect_id' => $outreachProspectId]
                    );

                    foreach ($stageIds as $stageId) {
                        Db::insert(
                            'INSERT INTO `sap_outreach_prospect_stage`
                              (`outreach_prospect_id`, `stage_id`)
                             VALUES
                              (:outreach_prospect_id, :stage_id)',
                            [
                                'outreach_prospect_id' => $outreachProspectId,
                                'stage_id'             => $stageId
                            ]
                        );
                    }


                    try {
                        if (!empty($stageIdsV2)) {
                            Db::query(
                                'DELETE FROM `sap_outreach_prospect_stage_v2` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                                ['outreach_prospect_id' => $outreachProspectId]
                            );

                            Util::addLog("Sync Prospects - : Inserting stage ids for prospect id ".$prospect_details['id']." from API v2.");

                            foreach ($stageIdsV2 as $stageIdV2) {
                                $op_stage_id = Db::insert(
                                    'INSERT INTO `sap_outreach_prospect_stage_v2`
                                      (`outreach_prospect_id`, `stage_id`)
                                     VALUES
                                      (:outreach_prospect_id, :stage_id)',
                                    [
                                        'outreach_prospect_id' => $outreachProspectId,
                                        'stage_id'             => $stageIdV2
                                    ]
                                );

                                if ($op_stage_id) {
                                    Util::addLog("Sync Prospects - : Stage Id $op_stage_id inserted for outreach prospect id $outreachProspectId.");
                                } else {
                                    Util::addLog("Sync Prospects - : Stage Id $op_stage_id not inserted for outreach prospect id $outreachProspectId.");
                                }
                            }
                        }
                    } catch (Exception $e) {
                        Util::addLog('Sync Prospects - Exception 3: ' . $e->getMessage());
                    }
                  
                }
            } else {
                print_r($prospect_res);
            }
            usleep(100000);
        }

        $prospectsReceived  = (50*($page-1)) + Util::val($prospects, ['data', 'meta', 'page', 'entries']) ?: 0;
        $totalProspects     = Util::val($prospects, ['data', 'meta', 'results', 'total']) ?: 0;
        $prospectsRemaining = ($prospectsReceived < $totalProspects) ? true : false;
        $page++;
        
        echo "\n\n Counted" . $exe_count;
        echo "\n\n Received" . $prospectsReceived;
        echo "\n\n ProspectsRemaining" . $prospectsRemaining;
        
        if (!$prospectsRemaining) {
            $page = 1;
        }       
    } else {
        Db::query(
            'UPDATE `sap_client_account_outreach` '
                . 'SET `status` = "connected", '
                . '`under_process_by` = "", '
                . '`last_pulled_at` = NOW() '
                . 'WHERE `id` = :id',
            ['id' => $account['id']]
        );
        Util::addLog("Sync Prospects - : Prospects data not retrieved for outreach account $accountId. from API v1.");
        exit();
    }
} while ($prospectsRemaining AND $exe_count <=5000);


Db::query(
    'UPDATE `sap_client_account_outreach` '
        . 'SET `status` = "connected", '
        . '`under_process_by` = "", '
        . '`last_pulled_at` = NOW() '
        . 'WHERE `id` = :id',
    ['id' => $account['id']]
);

Db::query(
    "UPDATE `sap_client_account_outreach` "
        . "SET `sync_stage_prospects_last_page` = '{$page}', "
        . "`sync_stage_prospects_updated_at` = NOW() "
        . "WHERE `id` = :id",
    ['id' => $account['id']]
); 

exit();
Util::addLog("Sync Prospects - : Syncing script end.");

function throwException($exception, $account) {
    if (!empty($account) AND is_array($account)) {
        Db::query(
            'UPDATE `sap_client_account_outreach` '
                . 'SET `under_process_by` = "", '
                . '`status` = "connected" '
                . 'WHERE `id` = :id',
            ['id' => $account['id']]
        );

        if (!empty($exception)) {
            throw $exception;
        } else {
            return null;
        }
    } else {
        return null;
    }
}
