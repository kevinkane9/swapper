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
        $data = json_decode($row['metadata'], true);

        $mailingId = null;

        if (is_array($data) && array_key_exists('mailing', $data) && array_key_exists('id', $data['mailing']) &&
            is_int($data['mailing']['id']) && $data['mailing']['id'] > 0
        ) {
            $mailingId = $data['mailing']['id'];
        }

        $values .= sprintf(
            "(%d, %d, %s, %s, %s, %s, %s, %s),",
            $row['id'],
            $row['outreach_prospect_id'],
            $row['event_id'],
            $row['template_id'] ?: 'null',
            $mailingId ?: 'null',
            "'". $row['action'] ."'",
            "'". $row['metadata'] ."'",
            "'" . $row['occurred_at'] ."'"
        );
    }

    $values = substr($values, 0, -1);

    Db::insert(
        'INSERT INTO `sap_outreach_prospect_event_v2`
     (`id`, `outreach_prospect_id`, `event_id`, `template_id`, `mailing_id`, `action`, `metadata`, `occurred_at`)
     VALUES '. $values
    );

    $rows = Db::fetchAll(
        'SELECT * FROM `sap_outreach_prospect_event` WHERE `id` > (SELECT MAX(`id`) FROM `sap_outreach_prospect_event_v2`) LIMIT 20'
    );
} while (count($rows) > 0);
