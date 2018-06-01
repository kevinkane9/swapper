<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

$inProgressFile = APP_ROOT_PATH . '/upload/.inbox-stats-in-progress';
if (file_exists($inProgressFile)) {
    exit();
}

if (isset($accountId)) {
    $accounts = [Db::fetch(
        'SELECT * FROM `sap_client_account_gmail` WHERE (`status` = "connected" OR `status` = "scanning") AND `id` = :id',
        ['id' => $accountId]
    )];
} else {
    $accounts = Db::fetchAll(
        'SELECT  *
           FROM `sap_client_account_gmail`
          WHERE `status` = "connected"
            AND (`last_scanned_at` IS NULL OR `last_scanned_at` < :one_minute_ago)
            AND (`retry_after` IS NULL OR `retry_after` < NOW())
       ORDER BY `last_scanned_at` ASC LIMIT 15',
        ['one_minute_ago' => date('Y-m-d H:i:s', time() - (150))]
    );
}

if (empty($accounts)) {
    exit;
}

touch($inProgressFile);
//## Util::addLog('Read-Labels Process: Lock File Created: ' . $inProgressFile);

## Util::addLog('Read-Labels Process: Labels Reading Process started for ' . sizeof($accounts) . ' gmail accounts.');

try {
foreach ($accounts as $account) {
    try {
        Util::addLog("Read-Labels-Counts - Processing Gmail Acount Id : " . $account['id']); 
        ## Util::addLog("Read-Labels Process: Labels Reading Process ended for , Account Id (" . $account['id']. ") and Client Id (" . $account['client_id']. ")");

//        Db::query(
//            'UPDATE `sap_client_account_gmail` SET `status` = "scanning", `retry_after` = NULL WHERE `id` = :id',
//            ['id' => $account['id']]
//        );    

        $labelsMap = [
            'Scheduling in Progress' => 'SIP',
            'Reschedule/Cancel'      => 'RC',
            'Referral'               => 'Ref',
            'Closed Lost'            => 'Closed',
            'Bad Email'              => 'Bad',
            'Unknown'                => 'Unknown',        
            'Inbox'                => 'Inbox',        
            'Confused' => 'Confused',
            'Check Back In (now)' => 'CBI',
            'Check Back In (1 Month)' => 'CBI 1',
            'Check Back In (2 Months)' => 'CBI 2',
            'Check Back In (3 Months)' => 'CBI 3',
            'Check Back In (4 Months)' => 'CBI 4',
            'Check Back In (6 Months)' => 'CBI 6',
            'Check Back In (8 Months)' => 'CBI 8',
            'Check Back In (12 Months)' => 'CBI 12',
            'Not Interested FUP' => 'NI',
            'Meeting in Progress FUP' => 'MIP FUP',
            'Rescheduled FUP' => 'RS',
            'Meeting Scheduled' => 'Meeting',
        ];
        //////////////////////////////////////
        ///  Begin Scan
        //////////////////////////////////////

        $client = new Google_Client();
        $client->setApplicationName(GOOGLE_APP);
        $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
        $client->setAccessToken(json_decode($account['access_token'], true));

        if ($client->isAccessTokenExpired()) {
            ## Util::addLog('Read-Labels Process: Access token ('.$account['access_token'].') expired. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            Db::query(
                'UPDATE `sap_client_account_gmail` SET `access_token` = :access_token WHERE `id` = :id',
                [
                    'access_token' => json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES),
                    'id'           => $account['id']
                ]
            );
        } else {
            ## Util::addLog('Read-Labels Process: Google Client Access token expired for account ' . $account['id']);
        }

        // scan label
        $gmail  = new Google_Service_Gmail($client);
        $params = [];

        $labelService = $gmail->users_labels;
        $labelsResponse = $labelService->listUsersLabels('me');

        $gmailLabels = $labelsResponse->getLabels();

        $gLabels = [];
        foreach ($gmailLabels as $gmailLabel) {
            $gmailLabelName = preg_replace('/\s+/', '', strtolower($gmailLabel->name));
            $gLabels[$gmailLabelName] = $gmailLabel->id;
        }    

        try {
            $account_stats = Db::fetch(
                "SELECT * FROM `sap_gmail_account_stats` WHERE `gmail_account_id` = '{$account['id']}'"
            );

            $label_cols_counts = [];
            foreach ($labelsMap as $labelNameOrg=>$labelValue) {
                $labelName = preg_replace('/\s+/', '', strtolower($labelNameOrg));
                if (!empty($gLabels[$labelName])) {
                    $labelId = $gLabels[$labelName];

                    $label = $labelService->get('me', $labelId);
                    $count = $label->getMessagesTotal();

                    $label_cols_counts['label_count_' . strtolower(str_replace([' ', '/'], '_', str_replace(['(', ')'], '', $labelNameOrg)))] = !empty($count) ? $count : 0;
                }
            }

            try {            
                if (!empty($label_cols_counts)) {
                    if (empty($account_stats)) {
                        Db::insert(
                            "INSERT INTO  `sap_gmail_account_stats`
                                     (gmail_account_id, " . implode(',',array_keys($label_cols_counts)) . ", created_at)
                              VALUES ({$account['id']}, " . implode(',',array_values($label_cols_counts)) . ", NOW())"
                        );
                    } else {
                        $label_sql = "UPDATE `sap_gmail_account_stats` 
                                SET `updated_at` = NOW(), ";

                        $i = 1;
                        
                        foreach ($label_cols_counts as $lb_col=>$lb_count) {
                            if ($i == count($label_cols_counts)) {
                                $label_sql .= "$lb_col=$lb_count";
                            } else {
                                $label_sql .= "$lb_col=$lb_count,";
                            }

                            $i++;
                        }

                        $label_sql .= " WHERE gmail_account_id = {$account['id']}";

                        Db::query( $label_sql );   
                    }
                }
            } catch (\Exception $e) {
                Util::addLog("Read-Labels-Counts - Exception Handler 0 Client ID : {$account['client_id']} Gmail Account Id {$account['id']}: " . $e->getMessage());
            }

            sleep(1);
         } catch (\Exception $e) {
             Util::addLog("Read-Labels-Counts - Exception Handler 1 Client ID : {$account['client_id']} Gmail Account Id {$account['id']}: " . $e->getMessage());
         }
    } catch (\Exception $e) {
       Util::addLog("Read-Labels-Counts - Exception Handler 2 Client ID : {$account['client_id']} Gmail Account Id {$account['id']}: " . $e->getMessage()); 
    }
    ## Util::addLog("Read-Labels Process: Labels Reading Process ended for , Account Id (" . $account['id']. ") and Client Id (" . $account['client_id']. ")");
}
} catch (\Exception $e) {
    Util::addLog("Read-Labels-Counts - Exception Handler 3: " . $e->getMessage()); 
}

unlink($inProgressFile);
