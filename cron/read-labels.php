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

$inProgressFile = APP_ROOT_PATH . '/upload/.read-labels-in-progress';

if (file_exists($inProgressFile)) {
    exit();
}

// gmail accounts
if (isset($accountId)) {
    $accounts = [Db::fetch(
        'SELECT * FROM `sap_client_account_gmail` WHERE (`status` = "connected" OR `status` = "scanning") AND `id` = :id',
        ['id' => $accountId]
    )];
} else {
    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_gmail` WHERE `status` = "scanning"');

    if ($count['count'] >= 15) {
        echo 'Max # of scanning already in progress';
        exit;
    }

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
    Util::addLog('Read-Labels Process: No Accounts to process, exiting scanning.');
    exit;
}

touch($inProgressFile);
//Util::addLog('Read-Labels Process: Lock File Created: ' . $inProgressFile);

Util::addLog('Read-Labels Process: Labels Reading Process started for ' . sizeof($accounts) . ' gmail accounts.');

try {
foreach ($accounts as $account) {
    Util::addLog("Read-Labels Process: Labels Reading Process ended for , Account Id (" . $account['id']. ") and Client Id (" . $account['client_id']. ")");
    
    $clientName = Db::fetchColumn(
        'SELECT * FROM `sap_client` WHERE `id` = :id',
        ['id' => $account['client_id']],
        'name'
    );

    $labelsMap = [
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
        Util::addLog('Read-Labels Process: Access token ('.$account['access_token'].') expired. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `access_token` = :access_token WHERE `id` = :id',
            [
                'access_token' => json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES),
                'id'           => $account['id']
            ]
        );
    } else {
        Util::addLog('Read-Labels Process: Google Client Access token expired for account ' . $account['id']);
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
        foreach ($labelsMap as $labelNameOrg=>$labelValue) {
            $labelName = preg_replace('/\s+/', '', strtolower($labelNameOrg));
            if (!empty($gLabels[$labelName])) {
                $labelId = $gLabels[$labelName];

                $totalMessagesCount = 0;
                $totalFromEmails = [];

                $messageService = $gmail->users_messages;
                $opt_param['pageToken'] = NULL;
                $opt_param['labelIds'] = $labelId;

                $lablesMessages = listMessages($gmail,'me',$opt_param);

                $count = count($lablesMessages);

                Util::addLog("Read-Labels Process: Label $labelValue messages parsing started");
                if ($count > 0) {
                    $totalMessagesCount += $count;

                    $f_emails = '';
                    foreach ($lablesMessages as $message) {
                        try {
                            /**
                             * @var $messageData Google_Service_Gmail_MessagePart
                             */

                            $messageData = $messageService->get('me', $message['id'], ['format' => 'raw']);
                            //sleep(1);
                            $rawData = $messageData->raw;
                            $sanitizedData = strtr($rawData, '-_', '+/');
                            $decodedMessage = base64_decode($sanitizedData);
                            $sentAt = date('Y-m-d H:i', substr($messageData->internalDate, 0, -3));
                            $sentAtFull = date('Y-m-d H:i:s', substr($messageData->internalDate, 0, -3));

                            $mailParser = new \ZBateson\MailMimeParser\MailMimeParser();
                            $mail = $mailParser->parse($decodedMessage);
                            $from = $mail->getHeaderValue('from');

                            $f_emails[$labelValue][$from] = $from;
                        } catch (\Exception $e) {
                            Util::addLog('Read-Labels Process - Exception: ' . $e->getMessage());
                        }
                    }
                }
                
                $outreach_account_rs = Db::fetchAll(
                    'SELECT * FROM `sap_client_account_outreach` WHERE `client_id` = :client_id',
                    ['client_id' => $account['client_id']]
                ); 

                if (!empty($outreach_account_rs)) {
                    foreach ($outreach_account_rs as $outreach_account) {
                        $access_token = $outreach_account['access_token'];
                        $outreach_account_id = $outreach_account['id'];

                        if (!empty($f_emails[$labelValue])) {
                            $prevUpdatedEmails = [];

                            $sql_outp = "SELECT * "
                                    . "FROM `sap_outreach_updated_prospects` "
                                    . "WHERE `client_id` = {$account['client_id']} "
                                    . "AND `label_value` = '$labelValue' "
                                    . "AND `outreach_account_id` = $outreach_account_id ";

                            $updated_outreach_prospects = Db::fetchAll(
                                $sql_outp
                            );

                            if (!empty($updated_outreach_prospects)) {
                                foreach ($updated_outreach_prospects as $updated_outreach_prospect) {
                                    $prevUpdatedEmails[$updated_outreach_prospect['prospect_email']] = $updated_outreach_prospect['prospect_email'];
                                }
                            }

                            /*foreach ($f_emails as $labelValue=>$fr_emails) {
                                foreach ($fr_emails as $f_email) {
                                    if (!in_array($f_email, $prevUpdatedEmails)) {
                                        $totalFromEmails[$f_email] = '';
                                        $params['filter']['contact/email'] = $f_email;
                                        $prospects = Outreach::call('prospects', $params, $access_token, 'get');  
                                        if (!empty($prospects['status']) AND $prospects['status'] == 'success') {
                                            if (!empty($prospects['data']['data'])) {
                                                $prospect = $prospects['data']['data'];                              
                                                ## Updating Prospect
                                                $data = [
                                                    'data' => [
                                                        'attributes'  => [
                                                            'metadata' => [
                                                                'custom' => array(4=>$labelValue)
                                                            ]
                                                        ]
                                                    ]
                                                ];

                                                $prospects = Outreach::call('prospects/' . $prospect[0]['id'], json_encode($data, JSON_UNESCAPED_SLASHES), $access_token, 'patch');
                                                if (!empty($prospects['status']) AND $prospects['status'] == 'success') {
                                                    Util::addLog("Read-Labels Process: Prospoect " . $prospect[0]['id'] . " updated successfully with label " . $labelValue . ", Account Id (" . $account['id']. ") and Client Id (" . $account['client_id']. ")");
                                                    try {
                                                        Db::query(
                                                            "INSERT INTO `sap_outreach_updated_prospects` (client_id,outreach_account_id,prospect_email,label,label_value,updated_at) VALUES (".$account['client_id'].",".$outreach_account_id.",'".$f_email."','".$labelId."','".$labelValue."',NOW())"
                                                        );
                                                    } catch (\Exception $e) {
                                                        Util::addLog("Read-Labels Process: Exception while adding prospect in cache table: " . $e->getMessage());
                                                    }                                         
                                                } else {
                                                    Util::addLog("Read-Labels Process: Prospoect " . $prospect[0]['id'] . " not updated.");
                                                }
                                            }                                 
                                        } else {
                                            Util::addLog("Read-Labels Process: Prospect not found at outreach server with email : " . $f_email);
                                        }
                                    }
                                }
                            }*/
                        } else {
                            Util::addLog("Read-Labels Process: Gmail '{$labelValue}' label folder is empty for client id {$account['client_id']}");
                        }
                    }
                } else {
                    Util::addLog("Read-Labels Process: Outreach account doesn't exist for client id {$account['client_id']}");
                }                
            }
        }
        sleep(1);
     } catch (\Exception $e) {
         Util::addLog("Read-Labels Process - Exception: " . $e->getMessage());
     }
//////////////////////////////////////
///  End Scan
//////////////////////////////////////

    endscan:
     
    Util::addLog("Read-Labels Process: Labels Reading Process ended for , Account Id (" . $account['id']. ") and Client Id (" . $account['client_id']. ")");
}
} catch (\Exception $e) {
    unlink($inProgressFile);
    Util::addLog('Read-Labels Process - Exception: ' . $e->getMessage());
}
Util::addLog('Read-Labels Process: Accounts (' . sizeof($accounts) . ') scanning completed.');
if (!empty($totalMessagesCount) AND $totalMessagesCount > 0) {
    Util::addLog("Read-Labels Process: {$totalMessagesCount} Messages and ".count($totalFromEmails)." From Emails were processed");    
}  

unlink($inProgressFile);
//Util::addLog('Read-Labels Process: Lock File Deleted: ' . $inProgressFile);

function throwException(\Exception $exception, $account) {

    $rethrow     = true;
    $nextAccount = true;

    if ('Google_Service_Exception' == get_class($exception) && null !== ($error = json_decode($exception->getMessage(), true))) {
        if (false !== strpos($error['error']['message'], 'Retry after')) {
            $matches = [];
            preg_match('/.*Retry after (.*)/', $error['error']['message'], $matches);

            if (array_key_exists(1, $matches)) {
                Db::query(
                    'UPDATE `sap_client_account_gmail` SET `retry_after` = :retry_after WHERE `id` = :id',
                    [
                        'retry_after' => date('Y-m-d H:i:s', strtotime($matches[1])),
                        'id'          => $account['id']
                    ]
                );

                $rethrow     = false;
                $nextAccount = true;
            }
        } elseif (false !== strpos($error['error']['message'], 'Not Found')) {
            $rethrow     = false;
            $nextAccount = false;
        }
    }

    if ($nextAccount) {
//        Db::query(
//            'UPDATE `sap_client_account_gmail` SET `status` = "connected" WHERE `id` = :id',
//            ['id' => $account['id']]
//        );
    }

    if ($rethrow) {
        unlink(APP_ROOT_PATH . '/upload/.inbox-sync-in-progress');

        throw $exception;
        exit;
    }

    return $nextAccount;
}


/**
 * Get list of Messages in user's mailbox.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @return array Array of Messages.
 */
function listMessages($service, $userId, $opt_param) {
  $pageToken = NULL;
  $messages = array();

  do {
    try {
      if ($pageToken) {
        $opt_param['pageToken'] = $pageToken;
      }
      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
      if ($messagesResponse->getMessages()) {
        $messages = array_merge($messages, $messagesResponse->getMessages());
        $pageToken = $messagesResponse->getNextPageToken();
      }
    } catch (Exception $e) {
      // print 'An error occurred: ' . $e->getMessage();
    }
  } while ($pageToken);
  
  return $messages;
}
