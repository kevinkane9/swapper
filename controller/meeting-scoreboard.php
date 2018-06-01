<?php

use Sapper\Route,
    Sapper\User,
    Sapper\Db,
    Sapper\GmailEvent;

// permissions
if (!User::can('manage-clients')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

// handle submissions
if ('POST' == $_SERVER['REQUEST_METHOD']) {
	// No Post Request for this yet
	
	$meeting_year_select = !empty($_POST['meeting_year_select']) ? $_POST['meeting_year_select'] : '';
}

if (empty($meeting_year_select)) {
	$meeting_year_select = date('Y');
}

// list pages
if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'meetings-calendar':
            $month = Route::uriParam('month');
            $year = Route::uriParam('year');

            $calendar_events = '';

            sapperView(
                'meetings-calendar',
                [
                    'month' => $month,
                    'year' => $year,
                ]
            );
            break;
        case 'meetings-calendar-data':
            $month = $_POST['month'];
            $year = $_POST['year'];
            $colors = implode(',', array_map([Db::dbh(), 'quote'], GmailEvent::getEligibleColors()));
            $events = Db::fetchAll(
                'SELECT *
                 FROM `sap_gmail_events` e
                 JOIN `sap_gmail_event_colors` c ON e.`event_color_id` = c.`id`
                 WHERE e.`status` != "cancelled" AND c.`background_color` IN ('. $colors .')
                 AND MONTH(e.`starts_at`) = :month',
                [
                    'month'  => $month,
                ]
            );

            if (!empty($events)) {
                $i = 0;
                foreach ($events as $event) {
                    if (date('H:i:s',  strtotime($event['ends_at'])) != '00:00:00') {
                        $calendar_events[$i]['title'] = $event['title'];
                        $calendar_events[$i]['start'] = date('Y-m-d H:i:s',  strtotime($event['starts_at']));
                        $calendar_events[$i]['end'] = date('Y-m-d H:i:s',  strtotime($event['ends_at']));
                        $i++;
                    }
                }
            }

            echo json_encode($calendar_events);
            break;
        case 'meetings-calendar-sapper':
            $month = Route::uriParam('month');
            $year = Route::uriParam('year');
            $calendar_events = '';

            sapperView(
                'meetings-calendar-sapper',
                [
                    'month' => $month,
                    'year' => $year,
                ]
            );
            break;
        case 'meetings-calendar-data-sapper':
            $month = $_POST['month'];
            $year = $_POST['year'];
            $colors = implode(',', array_map([Db::dbh(), 'quote'], GmailEvent::getEligibleColors()));
            $events = Db::fetchAll(
                'SELECT *
                 FROM `sap_gmail_events` e
                 JOIN `sap_gmail_event_colors` c ON e.`event_color_id` = c.`id`
                 WHERE e.`status` != "cancelled" AND c.`background_color` IN ('. $colors .')
                 AND MONTH(e.`starts_at`) = :month',
                [
                    'month'  => $month,
                ]
            );

            if (!empty($events)) {
                $i = 0;
                foreach ($events as $event) {
                    if (date('H:i:s',  strtotime($event['ends_at'])) != '00:00:00') {
                        $calendar_events[$i]['title'] = $event['title'];
                        $calendar_events[$i]['start'] = date('Y-m-d H:i:s',  strtotime($event['created_at']));
                        $calendar_events[$i]['end'] = date('Y-m-d H:i:s',  strtotime($event['created_at']));
                        $i++;
                    }
                }
            }

            echo json_encode($calendar_events);
            break;
    }
} else {
	$start = microtime();
    $colors = implode(',', array_map([Db::dbh(), 'quote'], GmailEvent::getEligibleColors()));

	for($m=1;$m<=12;$m++) {
		$meeting_score_sql = "SELECT `c`.`name` AS `client`,`c`.`id` AS `client_id`,
									`a`.`email` AS `inbox`,
									year(`e`.`starts_at`) AS `meeting_year`,
									count(*) AS `meetings_count`
							FROM `sap_gmail_events` `e`
										LEFT JOIN `sap_client_account_gmail` `a`
												ON `e`.`account_id` = `a`.`id`
										LEFT JOIN `sap_client` `c`
												ON `a`.`client_id` = `c`.`id`
                                        LEFT JOIN `sap_gmail_event_colors` ec
                                                ON e.`event_color_id` = ec.`id`
							WHERE ( month(`e`.`created_at`) = $m  AND year(`e`.`created_at`) = " . $meeting_year_select . ")
							AND ec.`background_color` IN ($colors)
							AND e.`status` != 'cancelled'
							GROUP BY MONTH(`e`.`created_at`), `e`.`account_id`";
				$meetings_per_month[$m] = Db::fetchAll($meeting_score_sql);

	}

	$meeting_arr = [];
	foreach ($meetings_per_month as $month=>$meetings) {
		if (!empty($meetings)) {
			foreach ($meetings as $meeting) {
				$month_name = substr(strtolower(DateTime::createFromFormat('!m', $month)->format('F')), 0,3);
				$meeting_arr[$meeting['client_id']]['meeting_count_' . $month_name] = $meeting['meetings_count'];
			}
		}
	}

    $synced_accounts = Db::fetchAll("
	SELECT `c`.`id` AS `client_id`,
                `a`.`id` AS `account_id`,
                `c`.`name` AS `client`,
                `a`.`email` AS `inbox`,
                `a`.`status` AS `gmail_status`
	FROM `sap_client` `c`
        LEFT JOIN `sap_client_account_gmail` `a`
            ON `c`.`id` = `a`.`client_id`
        WHERE '' = '' AND (`a`.`id` IS NOT NULL OR `a`.`id` != '')
        ");  
    
    $meeting_per_months_rs = Db::fetchAll("
	SELECT *
	FROM `sap_client_meetings_per_month` WHERE `year` = $meeting_year_select"); 
    
    $meeting_per_months = [];
    if (!empty($meeting_per_months_rs)) {
        foreach ($meeting_per_months_rs as $meeting_per_month) {
            $meeting_per_months[$meeting_per_month['client_id']] = $meeting_per_month;
        }
    }
    
    $pre_synced_account = [];    
    foreach ($synced_accounts as $synced_account) {
        $pre_synced_account[$synced_account['client_id']][$synced_account['account_id']] = $synced_account;
    }
    
    unset($synced_accounts);
	$synced_accounts = $pre_synced_account;
	
	$meeting_years[] = date('Y',strtotime("-1 year"));
	$meeting_years[] = date('Y');

    sapperView(
        'meeting-scoreboard',
        [
            'accounts' => $meeting_arr,
            'synced_accounts' => $synced_accounts,
            'meeting_years' => $meeting_years,
            'meeting_year_select' => $meeting_year_select,
            'meeting_per_months' => $meeting_per_months,
        ]
    );
}
