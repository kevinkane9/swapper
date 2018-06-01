<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\GmailEvent;

require_once(__DIR__ . '/../../init.php');

set_time_limit(0);

$accounts = Db::fetchAll("SELECT `id`, `default_color_id` FROM `sap_client_account_gmail` WHERE `status` <> 'disconnected'");

foreach ($accounts as $account) {
    // Update the colors definitions
    GmailEvent::captureGmailCalendarColorData($account['id']);

    // Update the colors of existing events
    $client = GmailEvent::getGoogleClient($account['id']);

    $calendar = new Google_Service_Calendar($client);

    $eventsService = $calendar->events;

    $events = Db::fetchAll(
        'SELECT `id`, `event_id` FROM `sap_gmail_events` WHERE `account_id` = :account_id',
        ['account_id' => $account['id']]
    );

    foreach ($events as $event) {
        try {
            $rEvent = $eventsService->get('primary', $event['event_id']);

            if ($rEvent->colorId) {
                $colorId = Db::fetchColumn(
                    'SELECT `id` FROM `sap_gmail_event_colors`
                WHERE `color_key` = :color_key AND `gmail_account_id` = :gmail_account_id
                AND `type` = "event"',
                    [
                        'color_key'        => $rEvent->colorId,
                        'gmail_account_id' => $account ['id'],
                    ],
                    'id'
                );
            } else {
                $colorId = $account['default_color_id'];
            }

            Db::updateRowById('gmail_events', $event['id'], ['event_color_id' => $colorId]);
        } catch (\Exception $e) {

        }
    }
}
