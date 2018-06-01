<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../../init.php');

set_time_limit(0);

$rows = Db::fetchAll(
    'SELECT * FROM `sap_outreach_prospect_event` WHERE `id` > (SELECT MAX(`id`) FROM `sap_outreach_prospect_event_v2`) LIMIT 20'
);

do {

    $values = '';

    foreach ($rows as $row) {

        $clientId = Db::fetchColumn(
            sprintf(
                'SELECT a.`client_id`
                   FROM `sap_outreach_prospect` op
              LEFT JOIN `sap_client_account_outreach` a ON op.`outreach_account_id` = a.`id`
                  WHERE op.`id` = %d',
                $row['outreach_prospect_id']
            ), [], 'client_id'
        );

        $values .= sprintf(
            "(%d, %d, %d, %s, %s, %s, %s, %s, %s),",
            $row['id'],
            $row['outreach_prospect_id'],
            $clientId,
            $row['event_id'],
            $row['template_id'] ?: 'null',
            $row['mailing_id'] ?: 'null',
            "'". $row['action'] ."'",
            "'". $row['metadata'] ."'",
            "'" . $row['occurred_at'] ."'"
        );
    }

    $values = substr($values, 0, -1);

    Db::insert(
        'INSERT INTO `sap_outreach_prospect_event_v2`
     (`id`, `outreach_prospect_id`, `client_id`, `event_id`, `template_id`, `mailing_id`, `action`, `metadata`, `occurred_at`)
     VALUES '. $values
    );

    $rows = Db::fetchAll(
        'SELECT * FROM `sap_outreach_prospect_event` WHERE `id` > (SELECT MAX(`id`) FROM `sap_outreach_prospect_event_v2`) LIMIT 20'
    );
} while (count($rows) > 0);
