<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\GmailEvent;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);
$admin_emails = explode(',', \Sapper\Settings::get('email-notifications'));
$send_email = true; // Enable/Disable email sending

$inProgressFile = APP_ROOT_PATH . '/upload/.inbox-sync-in-progress';

$debugMode = false;

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

if (array_key_exists(2, $argv) && 'debug' == $argv[2]) {
    $debugMode = true;
}

$time = "5";
if (!$debugMode && file_exists($inProgressFile)) {
    $fileTime = filemtime($inProgressFile); 
    if (time() > strtotime("+$time hours", $fileTime)) {
        // Send Email

        foreach ($admin_emails as $admin_email) {
            $email = trim($email);
            Sapper\Mail::send(
                'admin-notification',
                ['noreply@sappersuite.com', 'Sapper Suite'],
                [$admin_email, 'Sappersuite Admin'],
                'Uncaught Exception',
                [
                    'context'   => 'Sync Inbox Lock File',
                    'exception' => 'Sync Inbox Lock File has been locked for 5 hours, this lock file handles sync-inbox script'
                ]
            );
        }
    }    
    
    exit;
}

// gmail accounts
if (isset($accountId)) {
    $accounts = [Db::fetch(
        'SELECT * FROM `sap_client_account_gmail` WHERE `status` = "connected" AND `id` = :id',
        ['id' => $accountId]
    )];
} else {
    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_gmail` WHERE `status` = "scanning"');
    $max = 15;
    
    if (!$debugMode && $count['count'] >= $max) {
        Util::addLog("Max # of scanning {$max} already in progress");
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
    Util::addLog('No Accounts to process, exiting scanning.');
    exit;
}

if (!$debugMode) {
    touch($inProgressFile);
}

Util::addLog('Lock File Created: ' . $inProgressFile);

Util::addLog('Accounts (' . sizeof($accounts) . ') scanning started.');
foreach ($accounts as $account) {

    $clientName = Db::fetchColumn(
        'SELECT * FROM `sap_client` WHERE `id` = :id',
        ['id' => $account['client_id']],
        'name'
    );

    if (!$debugMode) {
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `status` = "scanning", `retry_after` = NULL WHERE `id` = :id',
            ['id' => $account['id']]
        );
    }

    $labelsMap = [
        'Scheduling in Progress' => $account['label_id_scheduling_in_progress'],
        'Reschedule/Cancel'      => $account['label_id_reschedule_cancel'],
        'Referral'               => $account['label_id_referral'],
        'Confused'               => $account['label_id_confused'],
        'Closed Lost'            => $account['label_id_closed_lost'],
        'Bad Email'              => $account['label_id_bad_email'],
        'Unknown'                => $account['label_id_unknown']
    ];

    //////////////////////////////////////
    ///  Begin Scan
    //////////////////////////////////////
	try {
		$client = new Google_Client();
		$client->setApplicationName(GOOGLE_APP);
		$client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
		$client->setAccessToken(json_decode($account['access_token'], true));

		if ($client->isAccessTokenExpired()) {
			Util::addLog('Access token ('.$account['access_token'].') expired. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			Db::query(
				'UPDATE `sap_client_account_gmail` SET `access_token` = :access_token WHERE `id` = :id',
				[
					'access_token' => json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES),
					'id'           => $account['id']
				]
			);
		}
	} catch (\Exception $e) {

        if ($send_email) {

            $exception = "Error : " . $e->getMessage();
            $exception .= '<br>';
            $exception .= "Error Trace: " . $e->getTraceAsString();

			$sapper_client = Db::fetch(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $account['client_id']]
            );
					
            foreach ($admin_emails as $admin_email) {

                Sapper\Mail::send(
                    'gmail-account-disconnected',
                    ['noreply@sappersuite.com', 'Sapper Suite'],
                    [$admin_email, 'Sappersuite Admin'],
                    'Gmail Account Disconnected',
                    [
                        'clientName'   => $sapper_client['name'],
                        'accountEmail' => $account['email'],
                        'exception'    => $exception
                    ]
                );
            }
        }

        Db::query(
            'UPDATE `sap_client_account_gmail` SET `status` = "disconnected" WHERE `id` = :id',
            [
                'id' => $account['id']
            ]
        );
        $client->revokeToken();

        Util::addLog('Sync Inbox Process: Exception raised: ' . $e->getMessage());

        continue;
	}

    // sync calendar
    beginCalendarSync:
    try {
			Util::addLog('Syncing calendar started. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
			$calendar = new Google_Service_Calendar($client);
			
			Util::addLog('Google calendar service instantiated: ' . json_encode($calendar) . '. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');			
			
			$eventsService = $calendar->events;

			Util::addLog('Google event service instantiated: ' . json_encode($eventsService) . '. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');			
			
			
			$events = $eventsService->listEvents(
				'primary',
				[
					'showDeleted'  => true,
					'singleEvents' => true,
					'updatedMin'   => date('Y-m-d', strtotime($account['last_scanned_at'])) . 'T' . date('H:i:s', strtotime($account['last_scanned_at'])) . '+00:00'
				]
			);
			
			Util::addLog('Google calendar service events response: ' . json_encode($events) . '. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');	
			
			/**
			 * @var $event Google_Service_Calendar_Event
			 */
			Util::addLog('Google calendar service: processing events: ' . count($events->getItems()) . '. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');				 
			foreach ($events->getItems() as $event) {

				if ('cancelled' == $event->getStatus()) {
					Util::addLog('Event (' . $event->id . ') cancelled. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
					Db::query(
						'UPDATE `sap_gmail_events` SET `status` = "cancelled" WHERE `event_id` = :event_id',
						['event_id' => $event->id]
					);
					continue;
				}

				$savedEvent = Db::fetch(
					'SELECT * FROM `sap_gmail_events` WHERE `event_id` = :event_id',
				 	['event_id' => $event->id]
				);

				$eventId = $savedEvent['id'];

				// event updated
				if (null !== $eventId) {
                    $eventCreateDate = $event->getCreated();
                    $eventStartDate = !empty($event->getStart()->dateTime)?$event->getStart()->dateTime:$event->getStart()->date;
                    $eventEndDate = !empty($event->getEnd()->dateTime)?$event->getEnd()->dateTime:$event->getEnd()->date;
                    $recipient = GmailEvent::hasValidRecipient($event, $account['survey_email']);

                    $data = [
                        'created_at'          => date('Y-m-d H:i:s', strtotime($eventCreateDate)),
                        'ends_at'             => date('Y-m-d H:i:s', strtotime($eventEndDate)),
                        'starts_at'           => date('Y-m-d H:i:s', strtotime($eventStartDate)),
                        'prospect_id'         => $recipient['prospect_id'],
                        'has_valid_recipient' => $recipient['valid_recipient'] ? 1 : 0,
                    ];

                    if ($event->colorId) {
                        $colorId = Db::fetchColumn(
                            'SELECT id FROM `sap_gmail_event_colors`
                            WHERE `color_key` = :color_key AND `gmail_account_id` = :gmail_account_id
                            AND `type` = "event"',
                            [
                                'color_key'        => $event->colorId,
                                'gmail_account_id' => $account ['id'],
                            ],
                            'id'
                        );
                    } else {
                        $colorId = $account['default_color_id'];
                    }

                    // Update the event color if it changed
                    if ($colorId != $savedEvent['event_color_id']) {
                        $data['event_color_id'] = $colorId;
                    }

                    if ('completed' == $savedEvent['status']) {
                        $newStartTime = strtotime($eventStartDate);
                        $newEndTime = strtotime($eventEndDate);
                        $savedStartTime = strtotime($savedEvent['starts_at']);
                        $savedEndTime = strtotime($savedEvent['ends_at']);

                        if ($newStartTime != $savedStartTime || $newEndTime != $savedEndTime) {
                            $data['starts_at'] = date('Y-m-d H:i:s', $newStartTime);
                            $data['ends_at'] = date('Y-m-d H:i:s', $newEndTime);
                            $data['status'] = 'active';

                            Db::updateRowById('gmail_events', $eventId, $data);
                            Util::addLog('Event Id (' . $eventId . ') updated. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
                            continue;
                        }
                    }

                    Db::updateRowById('gmail_events', $eventId, $data);

                    Util::addLog('Event Id (' . $eventId . ') updated. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
                    continue;
				}

                // capturing new event
                $recipient = GmailEvent::hasValidRecipient($event, $account['survey_email']);

                $eventCreateDate = $event->getCreated();
                $eventStartDate = !empty($event->getStart()->dateTime)?$event->getStart()->dateTime:$event->getStart()->date;
                $eventEndDate = !empty($event->getEnd()->dateTime)?$event->getEnd()->dateTime:$event->getEnd()->date;

                if ($event->colorId) {
                    $color = Db::fetch(
                        'SELECT id, background_color FROM `sap_gmail_event_colors`
                        WHERE `color_key` = :color_key AND `gmail_account_id` = :gmail_account_id
                        AND `type` = "event"',
                        [
                            'color_key'        => $event->colorId,
                            'gmail_account_id' => $account ['id'],
                        ]
                    );

                    $colorId = $color['id'];
                } else {
                    $colorId = $account['default_color_id'];
                }

                Db::createRow(
                    'gmail_events',
                    [
                        'account_id'          => $account['id'],
                        'event_id'            => $event->id,
                        'event_color_id'      => $colorId,
                        'created_at'          => date('Y-m-d H:i:s', strtotime($eventCreateDate)),
                        'starts_at'           => date('Y-m-d H:i:s', strtotime($eventStartDate)),
                        'ends_at'             => date('Y-m-d H:i:s', strtotime($eventEndDate)),
                        'status'              => 'active',
                        'title'               => $event->summary,
                        'prospect_id'         => $recipient['prospect_id'],
                        'has_valid_recipient' => $recipient['valid_recipient'] ? 1 : 0,
                    ]
                );
			}
			Util::addLog('Events (' . sizeof($events->getItems()) . ') added into database. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
			Util::addLog('Syncing calendar completed. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
	} catch (\Exception $e) {

	    // are we trying to sync too much data?
        if (false !== strpos($e->getMessage(), 'updatedMinTooLongAgo')) {
            $account['last_scanned_at'] = date('Y-m-d', time() - (60*60*24*15));
            goto beginCalendarSync;
        }

        $exception = "Error : " . $e->getMessage();
        $exception .= '<br>';
        $exception .= "Error Trace: " . $e->getTraceAsString();

        Util::addLog('Exception raised while Syncing calendar. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ') : \n\n' . $e->getMessage());
        if ($send_email) {
             $sapper_client = Db::fetch(
                    'SELECT * FROM `sap_client` WHERE `id` = :id',
                    ['id' => $account['client_id']]
                );

            foreach ($admin_emails as $admin_email) {

                Sapper\Mail::send(
                    'gmail-account-disconnected',
                    ['noreply@sappersuite.com', 'Sapper Suite'],
                    [$admin_email, 'Sappersuite Admin'],
                    'Gmail Account Disconnected',
                    [
                        'clientName'   => $sapper_client['name'],
                        'accountEmail' => $account['email'],
                        'exception'    => $exception
                    ]
                );
            }
        }

        Db::query(
            'UPDATE `sap_client_account_gmail` SET `status` = "disconnected" WHERE `id` = :id',
            [
                'id' => $account['id']
            ]
        );
        $client->revokeToken();

        Util::addLog('Sync Inbox Process: Exception raised: ' . $e->getMessage());

        continue;
	}
//////////////////////////////////////
///  End Scan
//////////////////////////////////////

    endscan:

    if (!$debugMode) {
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `status` = "connected", `last_scanned_at` = NOW() WHERE `id` = :id',
            ['id' => $account['id']]
        );
    }

        if ($account['client_id'] != 0) {
            try {
                $meeting_years[] = date('Y',strtotime("-1 year"));
                $meeting_years[] = date('Y');

                foreach ($meeting_years as $year) {
                    ## Util::addLog('Health score script started. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');

                    $sqlTotalMeetings = 'SELECT count(*) AS totalMeetings
                    FROM   (((`sap_gmail_events` `e`
                                              LEFT JOIN `sap_client_account_gmail` `a`
                                                             ON(( `e`.`account_id` = `a`.`id` )))
                                             LEFT JOIN `sap_client` `c`
                                                            ON(( `a`.`client_id` = `c`.`id` )))
                                            LEFT JOIN `sap_prospect` `p`
                                                       ON(( `e`.`prospect_id` = `p`.`id` )))
                    WHERE  ( 1=1 )
                    AND `a`.`id` = :account_id
                    AND year(`e`.`created_at`) = :year
                    GROUP BY `c`.`id`
                    ORDER by `c`.`id` DESC';

                    $rsTotalMeetings = Db::fetch(
                            $sqlTotalMeetings,
                            ['account_id' => $account['id'],'year' => $year]
                    );

                    $totalMeetings = !empty($rsTotalMeetings['totalMeetings']) ? (int)$rsTotalMeetings['totalMeetings'] : 0;

                    $client_data = Db::fetch(
                            'SELECT * FROM `sap_client` WHERE `id` = :id',
                            ['id' => $account['client_id']]
                    );

                    $contractMeetings = !empty((int) $client_data['contract_goal']) ? (int) $client_data['contract_goal'] : 0;

                    $healthScores = Db::fetch(
                            'SELECT * FROM `sap_client_health_score` 
                            WHERE `client_id` = :client_id 
                            AND `year` = :year
                            AND `gmail_account_id` = :gmail_account_id',
                            [
                                'client_id' => $account['client_id'],
                                'year' => $year,
                                'gmail_account_id' => $account['id'],
                                
                            ]
                    );

                    if (!empty($healthScores)) {
                        Db::query(
                                'UPDATE `sap_client_health_score` '
                                . 'SET `total_meetings` = ' . $totalMeetings . ', `contract_meetings` = ' . $contractMeetings . ', `modified_at` = NOW() '
                                . 'WHERE `client_id` = :client_id  '
                                . 'AND `year` = :year '
                                . 'AND `gmail_account_id` = :gmail_account_id',
                                [
                                'client_id' => $account['client_id'],
                                'year' => $year,
                                'gmail_account_id' => $account['id'],
                                ]
                        );
                    } else {
                        $scoreId = Db::insert(
                            'INSERT INTO sap_client_health_score (
                                    `client_id`,`year`,`gmail_account_id`,`total_meetings`,`contract_meetings`,
                                    `status`,`created_at`)
                                VALUES (
                                    :client_id,:year,:gmail_account_id,:total_meetings,:contract_meetings,
                                    :status,:created_at)',
                            [
                                'client_id' => $account['client_id'],
                                'year' => $year,
                                'gmail_account_id' => $account['id'],
                                'total_meetings'    => $totalMeetings,
                                'contract_meetings'    => $contractMeetings,
                                'status'  => 'Active',
                                'created_at'  => date("Y-m-d H:i:s"),
                            ]
                        );
                    }
                    # Inserting Total Meetings for this client - End

                    # Inserting Survey Feedback for this client - Begin
                    $feedback_attrs = ['right_prospect_opportunity_in_progress',
                    'right_prospect_no_opportunity',
                    'wrong_prospect_opportunity_in_progress',
                    'wrong_prospect',
                    'NA'];

                    $countFeedback = array();
                    foreach ($feedback_attrs as $feedback_attr) {
                            $sqlSurveyFeedback = 'SELECT c.id as client_id, s.feedback as feedback, count(s.feedback) as count_feedback
                                    FROM `sap_client` c
                                            LEFT JOIN `sap_client_account_gmail` a ON c.`id` = a.`client_id`
                                            LEFT JOIN `sap_gmail_events` e ON a.`id` = e.`account_id`
                                            LEFT JOIN `sap_survey` s ON  e.`event_id` = s.`event_id`
                                    WHERE e.event_id IS NOT NULL
                                            AND year(`e`.`created_at`) = :year
                                            AND s.id IS NOT NULL
                                            AND s.feedback = :feedback
                                            AND c.id = :client_id
                                    GROUP BY s.feedback
                                    ORDER BY c.id';

                            $rsSurveyFeedback = Db::fetch(
                                    $sqlSurveyFeedback,
                                    ['client_id' => $account['client_id'], 'year' => $year, 'feedback' => $feedback_attr]
                            );

                            $countFeedback[$feedback_attr] = !empty($rsSurveyFeedback['count_feedback']) ? (int)$rsSurveyFeedback['count_feedback'] : 0;
                    }
                
                    $healthScores = Db::fetch(
                        'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id AND `year` = :year AND `gmail_account_id` = :gmail_account_id',
                        [
                            'client_id' => $account['client_id'],
                            'year' => $year,
                            'gmail_account_id' => $account['id'],
                        ]
                    );
                    
                    if (!empty($healthScores)) {
                            Db::query(
                                    "UPDATE `sap_client_health_score` SET "
                                            . "`opp_in_progress` = " . $countFeedback['right_prospect_opportunity_in_progress'] . ", "
                                            . "`right_prospect_noip` = " . $countFeedback['right_prospect_no_opportunity'] . ", "
                                            . "`wrong_prospect_oip` = " . $countFeedback['wrong_prospect_opportunity_in_progress'] . ", "
                                            . "`wrong_prospect` = " . $countFeedback['wrong_prospect'] . ", "
                                            . "`no_prospect` = " . $countFeedback['NA'] . ", "
                                            . "`modified_at` = NOW() WHERE `client_id` = :client_id AND `year` = :year",
                                    ['client_id' => $account['client_id'], 'year' => $year]
                            );
                    } else {
                        $scoreId = Db::insert(
                                        "INSERT INTO sap_client_health_score (
                                                                        `opp_in_progress`,`right_prospect_noip`,
                                                                        `wrong_prospect_oip`,`wrong_prospect`,
                                                                        `no_prospect`,`client_id`,`year`,`gmail_account_id`,
                                                                        `status`,`created_at`)
                                                        VALUES (
                                                                        ':opp_in_progress',':right_prospect_noip',
                                                                        ':wrong_prospect_oip',':wrong_prospect',
                                                                        ':no_prospect',':client_id',':year',':gmail_account_id',
                                                                        ':status',':created_at')",
                                        [
                                                        'opp_in_progress' => $countFeedback['right_prospect_opportunity_in_progress'],
                                                        'right_prospect_noip' => $countFeedback['right_prospect_no_opportunity'],
                                                        'wrong_prospect_oip' => $countFeedback['wrong_prospect_opportunity_in_progress'],
                                                        'wrong_prospect' => $countFeedback['wrong_prospect'],
                                                        'no_prospect' => $countFeedback['NA'],
                                                        'client_id' => $account['client_id'],
                                                        'year' => $year,
                                                        'gmail_account_id' => $account['id'],
                                                        'status'  => 'Active',
                                                        'created_at'  => date("Y-m-d H:i:s"),
                                        ]
                        );
                    }
                    # Inserting Survey Feedback for this client - End

                    # Inserting Total Weeks for this client - Begin
                    $totalWeeksSinceLaunchSql = 'SELECT ROUND(DATEDIFF(NOW(), `c`.`launch_date`)/7, 0) AS totalweeks
                    FROM   `sap_client` `c`
                    WHERE  ( 1=1 )
                    AND `c`.`id` = :client_id
                    LIMIT 1;';

                    $rsTotalWeeksSinceLaunch = Db::fetch(
                            $totalWeeksSinceLaunchSql,
                            ['client_id' => $account['client_id']]
                    );

                    $totalWeeksSinceLastSql = 'SELECT ROUND(DATEDIFF(NOW(), `e`.`ends_at`)/7, 0) AS totalweeks
                    FROM   (((`sap_gmail_events` `e`
                                              LEFT JOIN `sap_client_account_gmail` `a`
                                                             ON(( `e`.`account_id` = `a`.`id` )))
                                             LEFT JOIN `sap_client` `c`
                                                            ON(( `a`.`client_id` = `c`.`id` )))
                                            LEFT JOIN `sap_prospect` `p`
                                                       ON(( `e`.`prospect_id` = `p`.`id` )))
                    WHERE  ( 1=1 )
                    AND year(`e`.`created_at`) = :year
                    AND `c`.`id` = :client_id
                    ORDER by `e`.`ends_at` DESC
                    LIMIT 1;';

                    $rsTotalWeeksSinceLast = Db::fetch(
                            $totalWeeksSinceLastSql,
                            ['client_id' => $account['client_id'],'year' => $year]
                    );
                    
                    $healthScores = Db::fetch(
                            'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id AND `year` = :year AND `gmail_account_id` = :gmail_account_id',
                            [
                                'client_id' => $account['client_id'],
                                'year' => $year,
                                'gmail_account_id' => $account['id'],
                            ]
                    );           

                    if (!empty($healthScores)) {
                            $wk_query = "UPDATE `sap_client_health_score` SET "
                                            . "`total_weeks` = '" . (int)$rsTotalWeeksSinceLaunch['totalweeks'] . "', "
                                            . "`weeks_last_meeting` = '" . (int)$rsTotalWeeksSinceLast['totalweeks'] . "', "
                                            . "`modified_at` = NOW() WHERE `client_id` = :client_id AND `year` = :year";

                            Db::query(
                                    $wk_query,
                                    ['client_id' => $account['client_id'], 'year' => $year]
                            );
                    } else {
                            $wk_query = "INSERT INTO sap_client_health_score (
                                            `total_weeks`,`weeks_last_meeting`,
                                            `client_id`, `year`, `status`,`created_at`)
                                        VALUES (
                                            '".$rsTotalWeeksSinceLaunch['totalweeks']."','".$rsTotalWeeksSinceLast['totalweeks']."',
                                            :client_id,:year,:status,:created_at)";
                            $scoreId = Db::insert(
                                            $wk_query,
                                            [
                                                'client_id' => $account['client_id'],
                                                'year' => $year,
                                                'status'  => 'Active',
                                                'created_at'  => date("Y-m-d H:i:s"),
                                            ]
                            );
                    }
                    # Inserting Total Weeks for this client - End
                }
            ## Util::addLog('Health score script completed. Account Id (' . $account['id']. ') and Client Id (' . $account['client_id']. ')');
        } catch (\Exception $e) {
            Util::addLog('Error in Health Score Calculation Process: -- ' . $e->getMessage() . '\n\n' . $e->getTraceAsString());
            if ($send_email) {
                foreach ($admin_emails as $admin_email) {
                    $email = trim($email);
                    Sapper\Mail::send(
                        'admin-notification',
                        ['noreply@sappersuite.com', 'Sapper Suite'],
                        [$admin_email, 'Sappersuite Admin'],
                        'Uncaught Exception',
                        [
                            'context'   => json_encode($account, JSON_UNESCAPED_SLASHES),
                            'exception' => json_encode([$e->getTraceAsString(),$e->getMessage()])
                        ]
                    );
                }
            }
        }
    }

}
Util::addLog('Accounts (' . sizeof($accounts) . ') scanning completed.');

if (!$debugMode) {
    unlink($inProgressFile);
}

Util::addLog('Lock File Deleted: ' . $inProgressFile);

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
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `status` = "connected" WHERE `id` = :id',
            ['id' => $account['id']]
        );
    }

    if ($rethrow) {
        unlink(APP_ROOT_PATH . '/upload/.inbox-sync-in-progress');

        throw $exception;
        exit;
    }

    return $nextAccount;
}
