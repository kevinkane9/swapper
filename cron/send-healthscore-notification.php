<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Mail;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$healthscores = Db::fetchAll(
    "SELECT hs.*, c.name AS client_name, a.email, a.survey_email, a.survey_results_email AS client_manager_email,
        a.status AS account_status
        FROM `sap_client_health_score` hs
            LEFT JOIN `sap_client` c ON hs.`client_id` = c.`id`
            LEFT JOIN `sap_client_account_gmail` a ON c.`id` = a.`client_id`
        WHERE (hs.notification_email_count = NULL OR hs.notification_email_count = '' OR hs.notification_email_count = 0) 
            AND a.`status` = 'connected'"
);


foreach ($healthscores as $healthscore) {
    $healthscore_value = Util::calculateHealthScore($healthscore);
    $notification_email_count = $healthscore['notification_email_count'];
    
    $emails = explode(',', $healthscore['client_manager_email']);

    foreach ($emails as $email) {
        $email = trim($email);

        Mail::send(
            'health-score-notification',
            ['noreply@sappersuite.com', 'Sapper Consulting'],
            [$email, $email],
            'Client Health score Notification',
            [
                'clientName'    => $healthscore['client_name'],
                'clientHealthScore' => $healthscore_value,
            ]
        );
        
    }
    
    $notification_email_count++;

    Db::query(
        'UPDATE `sap_client_health_score`'
            . ' SET `notification_email_count` = '.$notification_email_count.', '
            . ' `notification_email_sent_on` = NOW()'
            . ' WHERE `client_id` = :client_id',
        ['client_id' => $healthscore['client_id']]
    );
}
