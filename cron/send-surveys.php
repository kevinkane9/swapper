<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\GmailEvent;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

try {
    $extraCriteria = " DATE_SUB(NOW(), INTERVAL 55 MINUTE) >= `ends_at` AND e.status = 'active' ";
    $events = GmailEvent::getEligibleEvents($extraCriteria);

    if (!empty($events)) {
        foreach ($events as $event) {
            if (empty($event['survey_email'])) {

                Db::query(
                    'UPDATE `sap_gmail_events` SET `status` = "completed" WHERE `event_id` = :event_id',
                    ['event_id' => $event['event_id']]
                );

            } else {
                $emails = explode(',', $event['survey_email']);
                
                if (!empty($emails)) {

                    Util::sendSurveyInvitation($event, $emails);

                }
            }
        }
    }        
} catch (Exception $e) {
    Util::addLog('Send Surveys Process: Exception: ' . $e->getMessage());
}
