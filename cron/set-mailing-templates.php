<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$eventsWithoutTemplate = Db::fetchAll(
    'SELECT e.`id`, e.`created_at`, op.`id` AS `outreach_prospect_id`
       FROM `sap_gmail_events` e
  LEFT JOIN `sap_client_account_gmail` g ON e.`account_id` = g.`id`
  LEFT JOIN `sap_client_account_outreach` o ON g.client_id = o.client_id
  LEFT JOIN `sap_outreach_prospect` op ON op.prospect_id = e.`prospect_id` AND op.`outreach_account_id` = o.`id`
      WHERE e.`template_id` IS NULL
        AND op.`id` IS NOT NULL
   ORDER BY e.`id`'
);

$events = [];

foreach ($eventsWithoutTemplate as $eventWithoutTemplate) {
    if (array_key_exists($eventWithoutTemplate['id'], $events)) {
        $events[$eventWithoutTemplate['id']][] = $eventWithoutTemplate;
    } else {
        $events[$eventWithoutTemplate['id']] = [$eventWithoutTemplate];
    }
}

function findClosestsMailingAttribute($outreachProspectId, $eventCreatedAt, $returnAttribute = 'template_id') {
    return Db::fetchColumn(
        'SELECT *
           FROM `sap_outreach_prospect_mailing`
          WHERE `outreach_prospect_id` = :outreach_prospect_id
            AND `delivered_at` < :event_created_at
            AND `bounced` = 0
       ORDER BY `delivered_at` DESC
          LIMIT 1',
        [
            'outreach_prospect_id' => $outreachProspectId,
            'event_created_at'     => $eventCreatedAt
        ],
        $returnAttribute
    );
}

foreach ($events as $eventData) {

    if (count($eventData) > 1) {
        // multiple outreach accounts
        // assume the closest mailing is the correct one

        $eventDataToProcess = null;

        foreach ($eventData as $event) {
            $deliveredAt = findClosestsMailingAttribute(
                $event['outreach_prospect_id'],
                $event['created_at'],
                'delivered_at'
            );

            if ($deliveredAt > $eventDataToProcess) {
                $eventDataToProcess = $event;
            }
        }

    } else {
        $eventDataToProcess = $eventData[0];
    }

    Db::updateRowById(
        'gmail_events',
        $eventDataToProcess['id'],
        [
            'template_id' => findClosestsMailingAttribute(
                $eventDataToProcess['outreach_prospect_id'],
                $eventDataToProcess['created_at']
            )
        ]
    );

}
