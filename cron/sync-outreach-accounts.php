<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

// outreach accounts
if (isset($accountId)) {
    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_outreach` WHERE `status` = "connected" AND `id` = :id',
        ['id' => $accountId]
    );
} else {

    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status_v2` = "syncing"');

    if ($count['count'] >= 3) {
        echo 'Max # of syncs already in progress';
        exit;
    }

    $account = Db::fetch(
        'SELECT  *
           FROM `sap_client_account_outreach`
          WHERE `status_v2` = "connected"
            AND (`last_pulled_at_v2` IS NULL OR `last_pulled_at_v2` < :one_hour_ago)
       ORDER BY `last_pulled_at_v2` ASC',
        ['one_hour_ago' => date('Y-m-d H:i:s', time() - (7200))]
    );
}

if (empty($account)) {
    exit;
}

// begin sync
Db::updateRowById(
    'client_account_outreach',
    $account['id'],
    ['status_v2' => 'syncing']
);

try {
    $outreachSync = new \Sapper\Api\OutreachSync($account['id']);
    $outreachSync->sync();

    Db::query(
        'UPDATE `sap_client_account_outreach` SET `status_v2` = "connected", `last_pulled_at_v2` = NOW() WHERE `id` = :id',
        ['id' => $account['id']]
    );
} catch (\Exception $e) {
    Db::updateRowById(
        'client_account_outreach',
        $account['id'],
        ['status_v2' => 'connected']
    );

    throw $e;
}
