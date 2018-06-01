<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$clients   = Db::fetchColumn('SELECT COUNT(*) AS `count` FROM `sap_client`', [], 'count');
$syncing   = Db::fetchColumn('SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status` = "syncing"', [], 'count');
$prospects = Db::fetchColumn('SELECT COUNT(*) AS `count` FROM `sap_prospect`', [], 'count');
$events    = Db::fetchColumn('SELECT COUNT(*) AS `count` FROM `sap_outreach_prospect_event`', [], 'count');

Db::query(
    'UPDATE `sap_dashboard_stat`
        SET `clients` = :clients, `accounts_syncing` = :accounts_syncing, `prospects` = :prospects, `prospect_events` = :prospect_events
      WHERE `id` = 1',
    [
        'clients'          => $clients,
        'accounts_syncing' => $syncing,
        'prospects'        => $prospects,
        'prospect_events'  => number_format($events/1000000, 1)
    ]
);
