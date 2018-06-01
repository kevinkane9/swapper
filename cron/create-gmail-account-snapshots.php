<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$accounts = Db::fetchAll('SELECT * FROM `sap_client_account_gmail`');

foreach ($accounts as $account) {
    try {
        Db::insert(
            'INSERT INTO  `sap_gmail_account_snapshot`
                         (`gmail_account_id`, `created_at`, `label_count_scheduling_in_progress`,
                          `label_count_reschedule_cancel`, `label_count_referral`, `label_count_confused`,
                          `label_count_closed_lost`, `label_count_bad_email`, `label_count_unknown`)
                  VALUES (:gmail_account_id, :created_at, :label_count_scheduling_in_progress,
                          :label_count_reschedule_cancel, :label_count_referral, :label_count_confused,
                          :label_count_closed_lost, :label_count_bad_email, :label_count_unknown)',
            [
                'gmail_account_id'                   => $account['id'],
                'created_at'                         => date('Y-m-d'),
                'label_count_scheduling_in_progress' => $account['label_count_scheduling_in_progress'] ?: 0,
                'label_count_reschedule_cancel'      => $account['label_count_reschedule_cancel'] ?: 0,
                'label_count_referral'               => $account['label_count_referral'] ?: 0,
                'label_count_confused'               => $account['label_count_confused'] ?: 0,
                'label_count_closed_lost'            => $account['label_count_closed_lost'] ?: 0,
                'label_count_bad_email'              => $account['label_count_bad_email'] ?: 0,
                'label_count_unknown'                => $account['label_count_unknown'] ?: 0
            ]
        );
    } catch (\Exception $e) {
        //
    }
}
