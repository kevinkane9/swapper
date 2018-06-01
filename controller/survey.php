<?php

use Sapper\Route,
    Sapper\Db;

$eventId = Route::uriParam('event_id');

$event   = Db::fetch(
    'SELECT * FROM `sap_gmail_events` WHERE `event_id` = :event_id',
    ['event_id' => $eventId]
);

$state = 'new';
if (false == $event) {
    $state = 'not_found';
} elseif ('completed' == $event['status']) {
    $state = 'completed';
}

if ('POST' == $_SERVER['REQUEST_METHOD'] && 'new' == $state) {
    
    try {
        Db::insert(
            'INSERT INTO  `sap_survey`
                         (`event_id`, `prospect_name`, `prospect_attended`, `feedback`, `feedback_other`, `comments`)
                  VALUES (:event_id, :prospect_name, :prospect_attended, :feedback, :feedback_other, :comments)',
            [
                'event_id'           => $event['event_id'],
                'prospect_name'      => $_POST['prospect_name'] ?: null,
                'prospect_attended'  => $_POST['prospect_attended'],
                'feedback'           => $_POST['feedback'],
                'feedback_other'     => $_POST['feedback_other'] ?: null,
                'comments'           => $_POST['comments'] ?: null
            ]
        );

        Db::query(
            'UPDATE `sap_gmail_events` SET `status` = "completed" WHERE `event_id` = :event_id',
            ['event_id' => $eventId]
        );
    } catch (Exception $exc) {
        echo $exc->getMessage();
        echo "<br>";
        echo "<br>";
        echo $exc->getTraceAsString();
        die();
    }


    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_gmail` WHERE `id` = :id',
        ['id' => $event['account_id']]
    );

    $client = Db::fetch(
        'SELECT * FROM `sap_client` WHERE `id` = :id',
        ['id' => $account['client_id']]
    );

    if (!empty($event['prospect_id'])) {
        $prospect = Db::fetch(
            'SELECT * FROM `sap_prospect` WHERE `id` = :id',
            ['id' => $event['prospect_id']]
        );

        $prospectName = $prospect['first_name'] . ' ' . $prospect['last_name'];
    }

    $emails = explode(',', $account['survey_results_email']);

    foreach ($emails as $email) {
        $email = trim($email);

        Sapper\Mail::send(
            'survey-results',
            ['noreply@sappersuite.com', 'Sapper Suite'],
            [$email, $email],
            'Survey Results from '.$client['name'],
            [
                'client'             => $client['name'],
                'account'            => $account['email'],
                'prospect_name'      => isset($prospectName) ? $prospectName : ($_POST['prospect_name'] ?: null),
                'prospect_attended'  => $_POST['prospect_attended'],
                'feedback'           => $_POST['feedback'],
                'feedback_other'     => $_POST['feedback_other'] ?: null,
                'comments'           => $_POST['comments'] ?: null
            ]
        );
    }

    $state = 'submitted';
}

$prospect = null;

if ('' !== $event['prospect_id']) {
    $prospect = Db::fetch(
        'SELECT * FROM `sap_prospect` WHERE `id` = :id',
        ['id' => $event['prospect_id']]
    );
}

include_once(APP_ROOT_PATH . '/view/survey.php');
exit;