<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Api\Outreach;
use Sapper\Db;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

// outreach accounts
if (isset($accountId)) {
    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
        ['id' => $accountId]
    );
} else {
    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status` = "syncing" AND `under_process_by` = "' . basename(__FILE__, '.php') . '"');

    if ($count['count'] >= 25) {
        Util::addLog("Download Outreach Mailings - Max # of syncs ({$count['count']}) already in progress exiting now."); 
        echo 'Max # of syncs already in progress';
        exit;
    }

    $account = Db::fetch(
        'SELECT  *
           FROM `sap_client_account_outreach`
          WHERE `status` = "connected"
            AND (`outreach_scanned_at` IS NULL OR `outreach_scanned_at` < :one_hour_ago) ORDER BY `outreach_scanned_at` ASC',
        ['one_hour_ago' => date('Y-m-d H:i:s', time() - (7200))]
    );
}

if (empty($account)) {
    exit;
}

$accountId = $account['id'];
$outreach = $account;
$last_scan_end_date = $account['outreach_scanned_end_date'];

if (!empty(trim($last_scan_end_date)) AND strtotime($last_scan_end_date) > 0) {
    if (date('m', strtotime($last_scan_end_date)) < date('m')) {
        $date_start = date('Y-m-d', strtotime('-1 day', strtotime($last_scan_end_date)));
        $date_end = date('Y-m-d', strtotime('+10 day', strtotime($last_scan_end_date)));   
    } else {
        if (date('d', strtotime($last_scan_end_date)) < date('d')) {
            $date_start = date('Y-m-d', strtotime('-1 day', strtotime($last_scan_end_date)));
            $date_end = date('Y-m-d');
        } else {
            $date_start = date('Y-m-01');
            $date_end = date('Y-m-d');
        }
    }
} else {
    $date_start = date('Y-01-01');
    $date_end = date('Y-01-t');
}

Db::query(
    'UPDATE `sap_client_account_outreach` SET `status` = "syncing",`under_process_by` = "' . basename(__FILE__, '.php') . '" WHERE `id` = :id',
    ['id' => $accountId]
);

try {
    Util::addLog("Download Outreach Mailings - Executing Outreach Account {$accountId}"); 
    // sync mailings
    $offset            = 0;
    $page               = 1;
    $per_page            = 100;
    $mailingsRemaining = false;
    $params             = [];
    $mailingsReceived  = 0;
    $time_start = time();

    do {
        $offset = ($page - 1) * $per_page;

        $params['page[offset]'] = $offset;
        $params['page[limit]'] = $per_page;
        $params['filter[updatedAt]'] = $date_start . ".." . $date_end;
        $params['sort'] = 'updatedAt';

        // re-fetch account in case access token has been refreshed since last API query
        $outreach_account = Db::fetch(
            'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
            ['id' => $outreach['id']]
        );

        $access_token = $outreach_account['access_token'];  
            try {
                $response = Outreach::call(
                    'mailings',
                    $params,
                    $access_token,
                    'get',
                    Outreach::URL_REST_v2
                );
            } catch (Exception $exc) {
                Util::addLog("Download Outreach Mailings - Exception Handler 0: " . $exc->getMessage()); 

                Db::query(
                    'UPDATE `sap_client_account_outreach` '
                        . 'SET `status` = "connected", '
                        . '`outreach_scanned_at` = NOW(), `under_process_by` = "", '
                        . '`outreach_scanned_end_date` = "' . $date_end . '" '
                        . 'WHERE `id` = :id',
                    ['id' => $accountId]
                );
                    
                die();
            }

        if ('success' == $response['status']) {
            $totalMailings = Util::val($response, ['data', 'meta', 'count']) ?: 0;
            
            $mailing_date_end = '';
            foreach ($response['data']['data'] as $mailing) {  
                $mailing_date_end = date('Y-m-d', strtotime('-1 day', strtotime($mailing['attributes']['updatedAt'])));   

                try {            
                    $mailing_data = Db::fetch(
                        "SELECT * FROM `sap_prospect_mailings` WHERE `outreach_account_id` = {$outreach_account['id']} AND `mailing_id` = :mailing_id",
                        ['mailing_id' => $mailing['id']]
                    );

                    if (!empty($mailing_data)) {
                        Db::query(
                            "UPDATE sap_prospect_mailings
                            SET "
                            . "`bounced_at` = '{$mailing['attributes']['bouncedAt']}', "
                            . "`click_count` = '{$mailing['attributes']['clickCount']}', "
                            . "`clicked_at` = '{$mailing['attributes']['clickedAt']}', "
                            . "`created_at` = '{$mailing['attributes']['createdAt']}', "
                            . "`delivered_at` = '{$mailing['attributes']['deliveredAt']}', "
                            . "`mailbox_address` = '{$mailing['attributes']['mailboxAddress']}', "
                            . "`mailing_type` = '{$mailing['attributes']['mailingType']}', "
                            . "`open_count` = '{$mailing['attributes']['openCount']}', "
                            . "`opened_at` = '{$mailing['attributes']['openedAt']}', "
                            . "`replied_at` = '{$mailing['attributes']['repliedAt']}', "
                            . "`state` = '{$mailing['attributes']['state']}', "
                            . "`state_changed_at` = '{$mailing['attributes']['stateChangedAt']}', "
                            . "`meta_data` = '', "
                            . "`updated_at` = '{$mailing['attributes']['updatedAt']}', "
                            . "`unsubscribed_at` = '{$mailing['attributes']['unsubscribedAt']}', "
                            . "`date_updated` = NOW() WHERE `mailing_id` = {$mailing['id']} AND `outreach_account_id` = '{$outreach_account['id']}' "
                        );
                    } else {
                        Db::query(
                            "INSERT INTO `sap_prospect_mailings` 
                                (
                                    `mailing_id`, `outreach_account_id`, `bounced_at`, 
                                    `click_count`, `clicked_at`, `created_at`, 
                                    `delivered_at`, `mailbox_address`, 
                                    `mailing_type`, `open_count`, `opened_at`, 
                                    `replied_at`, `state`, `state_changed_at`, 
                                    `updated_at`, `unsubscribed_at`, `meta_data`, `prospect_id`, 
                                    `date_created`
                                ) VALUES (
                                    '{$mailing['id']}','{$outreach['id']}','{$mailing['attributes']['bouncedAt']}', 
                                    '{$mailing['attributes']['clickCount']}', 
                                    '{$mailing['attributes']['clickedAt']}', 
                                    '{$mailing['attributes']['createdAt']}', 
                                    '{$mailing['attributes']['deliveredAt']}', 
                                    '{$mailing['attributes']['mailboxAddress']}', 
                                    '{$mailing['attributes']['mailingType']}', 
                                    '{$mailing['attributes']['openCount']}', 
                                    '{$mailing['attributes']['openedAt']}', 
                                    '{$mailing['attributes']['repliedAt']}', 
                                    '{$mailing['attributes']['state']}', 
                                    '{$mailing['attributes']['stateChangedAt']}', 
                                    '{$mailing['attributes']['updatedAt']}', 
                                    '{$mailing['attributes']['unsubscribedAt']}', 
                                    '', 
                                    '{$mailing['relationships']['prospect']['data']['id']}',
                                    NOW()
                                );"
                        );   
                    }
                } catch (\Exception $e) {
                   Util::addLog("Download Outreach Mailings - Exception Handler 3: " . $exc->getMessage()); 
                   Db::query(
                        'UPDATE `sap_client_account_outreach` '
                           . 'SET `status` = "connected", '
                           . '`outreach_scanned_at` = NOW(), '
                           . '`under_process_by` = "", '
                           . '`outreach_scanned_end_date` = "'.$date_end.'" '
                           . 'WHERE `id` = :id',
                        ['id' => $accountId]
                    );
                }
            }
            /**/

            $mailingsReceived  += count($response['data']['data']) ?: 0;
            $mailingsRemaining = $totalMailings - $mailingsReceived;
            echo "$mailingsRemaining \n\n";
            
            $mailingsRemaining = ($mailingsReceived < $totalMailings) ? true : false;
        } else {
            $api_errors = json_decode($response['error'], true);
            $api_error = $api_errors['errors'][0];

            Util::addLog("Download Outreach Mailings - Error Raised by Outreach API Sever for Account Id {$accountId} - Response Dump: " . json_encode($response)); 
            
            if (!empty($api_error['id']) AND $api_error['id'] == 'pageParameter.offsetTooLarge') {
                if (!empty($mailing_date_end)) {
                    $date_end = $mailing_date_end;
                }
            } else if (!empty($api_error['id']) AND $api_error['id'] == 'rateLimitExceeded') {
                
            }
            
            Db::query(
                'UPDATE `sap_client_account_outreach` '
                    . 'SET `status` = "connected", '
                    . '`outreach_scanned_at` = NOW(), '
                    . '`under_process_by` = "", '
                    . '`outreach_scanned_end_date` = "' . $date_end . '" '
                    . 'WHERE `id` = :id',
                ['id' => $accountId]
            );
            
            exit();            
        }

        $page++;
    //    usleep(1000000);
    } while ($mailingsRemaining); 
} catch (\Exception $e) {
    Util::addLog("Download Outreach Mailings - Exception Handler 3: " . $e->getMessage()); 
    Db::query(
        'UPDATE `sap_client_account_outreach` '
            . 'SET `status` = "connected", '
            . '`outreach_scanned_at` = NOW(), '
            . '`under_process_by` = "", '
            . '`outreach_scanned_end_date` = "' . $date_end . '" '
            . 'WHERE `id` = :id',
        ['id' => $accountId]
    ); 
        
    exit();
}

Util::addLog("Download Outreach Mailings - Processing Complete Outreach Account Id : " . $accountId); 

Db::query(
    'UPDATE `sap_client_account_outreach` '
        . 'SET `status` = "connected", '
        . '`outreach_scanned_at` = NOW(), '
        . '`under_process_by` = "", '
        . '`outreach_scanned_end_date` = "' . $date_end . '" '
        . 'WHERE `id` = :id',
    ['id' => $accountId]
);
    
exit();
