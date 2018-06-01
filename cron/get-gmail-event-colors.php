<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\GmailEvent;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$accounts = Db::fetchAll("SELECT id from `sap_client_account_gmail` WHERE status <> 'disconnected'");

foreach ($accounts as $account) {
    GmailEvent::captureGmailCalendarColorData($account['id']);
}
