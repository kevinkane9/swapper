<?php

use Sapper\Route,
    Sapper\Db,
    Sapper\GmailEvent;

switch (Route::uriParam('action')) {

    case 'pre-oauth':

        $client = new Google_Client();
        $client->setApplicationName(GOOGLE_APP);
        $client->setScopes(
            [
                Google_Service_Gmail::GMAIL_MODIFY,
                Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
                Google_Service_Calendar::CALENDAR
            ]
        );
        $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
        $client->setRedirectUri($GLOBALS['sapper-env']['APP_ROOT_URL']. '/gmail/oauth');
        $client->setState(Route::uriParam('client_id'));
        $client->setAccessType('offline');

        header('Location: ' . $client->createAuthUrl());
        exit;
        break;

    case 're-auth':

        $client = new Google_Client();
        $client->setApplicationName(GOOGLE_APP);
        $client->setScopes(
            [
                Google_Service_Gmail::GMAIL_MODIFY,
                Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
                Google_Service_Calendar::CALENDAR
            ]
        );
        $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
        $client->setRedirectUri($GLOBALS['sapper-env']['APP_ROOT_URL']. '/gmail/oauth');
        $client->setState('r'. Route::uriParam('account_id'));
        $client->setAccessType('offline');

        header('Location: ' . $client->createAuthUrl());
        exit;
        break;

    case 'oauth':
        set_time_limit(0);
        $state = Route::uriParam('state');
        $code  = Route::uriParam('code');

        try {
            $client = new Google_Client();
            $client->setApplicationName(GOOGLE_APP);
            $client->setScopes(
                [
                    Google_Service_Gmail::GMAIL_MODIFY,
                    Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
                    Google_Service_Calendar::CALENDAR
                ]
            );
            $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
            $client->setAccessType('offline');
            $client->fetchAccessTokenWithAuthCode($code);

            $accessTokenEncoded = json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES);
            $clientAccessToken = json_decode($accessTokenEncoded, true);
            
            $gmail = new Google_Service_Gmail($client);
            $user  = $gmail->users->getProfile('me');

            // is this a re-connect or a brand new link?
            if ('r' == substr($state, 0, 1)) {

                $accountId = substr($state, 1);

                Db::query(
                    'UPDATE `sap_client_account_gmail` SET `status` = "connected", `access_token` = :access_token WHERE `id` = :id',
                    [
                        'access_token' => $accessTokenEncoded,
                        'id'           => $accountId
                    ]
                );

                $clientId = Db::fetchColumn(
                    'SELECT `client_id` FROM `sap_client_account_gmail` WHERE `id` = :id',
                    ['id' => $accountId],
                    'client_id'
                );

            } else {

                $clientId = $state;

                // initialize labels
                $userLabelService = $gmail->users_labels;
                $userLabels       = $userLabelService->listUsersLabels('me')->getLabels();

                $labels = [
                    'label_id_scheduling_in_progress' => ['label' => 'Scheduling in Progress', 'id' => null],
                    'label_id_reschedule_cancel'      => ['label' => 'Reschedule/Cancel',      'id' => null],
                    'label_id_referral'               => ['label' => 'Referral',               'id' => null],
                    'label_id_confused'               => ['label' => 'Confused',               'id' => null],
                    'label_id_closed_lost'            => ['label' => 'Closed Lost',            'id' => null],
                    'label_id_bad_email'              => ['label' => 'Bad Email',              'id' => null],
                    'label_id_unknown'                => ['label' => 'Unknown',                'id' => null],
                    'label_id_flop'                => ['label' => 'FLOP',                'id' => null],
                    'label_id_referral_new'                => ['label' => 'Referral (New)',                'id' => null],
                    'label_id_referral_reached_out'                => ['label' => 'Referral (Reached Out)',                'id' => null],
                    'label_id_check_in'                => ['label' => 'Check In',                'id' => null],
                    'label_id_check_in_jan'                => ['label' => 'Check In/January',                'id' => null],
                    'label_id_check_in_feb'                => ['label' => 'Check In/February',                'id' => null],
                    'label_id_check_in_mar'                => ['label' => 'Check In/March',                'id' => null],
                    'label_id_check_in_apr'                => ['label' => 'Check In/April',                'id' => null],
                    'label_id_check_in_may'                => ['label' => 'Check In/May',                'id' => null],
                    'label_id_check_in_jun'                => ['label' => 'Check In/June',                'id' => null],
                    'label_id_check_in_jul'                => ['label' => 'Check In/July',                'id' => null],
                    'label_id_check_in_aug'                => ['label' => 'Check In/August',                'id' => null],
                    'label_id_check_in_sep'                => ['label' => 'Check In/September',                'id' => null],
                    'label_id_check_in_oct'                => ['label' => 'Check In/October',                'id' => null],
                    'label_id_check_in_nov'                => ['label' => 'Check In/November',                'id' => null],
                    'label_id_check_in_dec'                => ['label' => 'Check In/December',                'id' => null],
                    'label_id_closed_lost_retired'                => ['label' => 'Closed Lost/Retired',                'id' => null],
                    'label_id_closed_lost_out_of_territory'                => ['label' => 'Closed Lost/Out of Territory',                'id' => null],
                    'label_id_meeting_scheduled'                => ['label' => 'Meeting Scheduled',                'id' => null],
                    'label_id_rescheduled'                => ['label' => 'Reschedule',                'id' => null],
                    'label_id_client_collateral'                => ['label' => 'Client Collateral',                'id' => null],
                    'label_id_need_phone_no'                => ['label' => 'Need phone number (after calendar confirmation has sent)',                'id' => null],
                    'label_id_waiting_on_client_response'   => ['label' => 'Waiting on Client Response',  'id' => null],
                    'label_id_out_of_office'                => ['label' => 'Out of Office',  'id' => null],
                ];

                // check if any labels already exist
                foreach ($labels as $labelKey => $labelData) {
                    foreach ($userLabels as $userLabel) {
                        if (strtolower($userLabel['name']) == strtolower($labelData['label'])) {
                            $labels[$labelKey]['id'] = $userLabel['id'];
                        }
                    }
                }

                // create missing labels
                foreach ($labels as $labelKey => $labelData) {
                    if (null == $labelData['id']) {
                        $newLabel = new Google_Service_Gmail_Label();
                        $newLabel->setName($labelData['label']);
                        $newLabel->setLabelListVisibility('labelShow');
                        $newLabel->setMessageListVisibility('show');

                        $labelCreated = $userLabelService->create('me', $newLabel);

                        $labels[$labelKey]['id'] = $labelCreated->id;
                    }
                }

                // Created gmail filter:
                $userFilterService = $gmail->users_settings_filters;
                $userFilter = $userFilterService->listUsersSettingsFilters('me')->getFilter();

                $is_postmaster_filter_exist = false;
                $is_out_of_office_filter_exist = false;
                foreach ( $userFilter as $userfilterlist )
                {
                    if( $userfilterlist->criteria->from != '' && $userfilterlist->criteria->from == 'postmaster' )
                        $is_postmaster_filter_exist = true;

                    if( $userfilterlist->criteria->query != '' && $userfilterlist->criteria->query == 'out of office' )
                        $is_out_of_office_filter_exist = true;
                }

                if( $is_postmaster_filter_exist === false )
                {
                    $postmasterOption = array( 'id' => 'me',
                        'criteria' => array( 'from' => 'postmaster' ),
                        'action' => array( 'addLabelIds' => [$labels['label_id_bad_email']['id']]  )
                    );

                    $postmasterFilter = new Google_Service_Gmail_Filter($postmasterOption);
                    $gmail->users_settings_filters->create('me', $postmasterFilter);
                }

                if( $is_out_of_office_filter_exist === false )
                {
                    $outofofficeOption = array( 'id' => 'me',
                        'criteria' => array( 'query' => 'out of office' ),
                        'action' => array( 'addLabelIds' => [$labels['label_id_out_of_office']['id']]  )
                    );
                    $outofofficeFilter = new Google_Service_Gmail_Filter($outofofficeOption);
                    $gmail->users_settings_filters->create('me', $outofofficeFilter);
                }

                $accountId = Db::createRow(
                    'client_account_gmail',
                    [
                        'client_id'                             => $clientId,
                        'email'                                 => $user->emailAddress,
                        'access_token'                          => $accessTokenEncoded,
                        'label_id_scheduling_in_progress'       => $labels['label_id_scheduling_in_progress']['id'],
                        'label_id_reschedule_cancel'            => $labels['label_id_reschedule_cancel']['id'],
                        'label_id_referral'                     => $labels['label_id_referral']['id'],
                        'label_id_confused'                     => $labels['label_id_confused']['id'],
                        'label_id_closed_lost'                  => $labels['label_id_closed_lost']['id'],
                        'label_id_bad_email'                    => $labels['label_id_bad_email']['id'],
                        'label_id_unknown'                      => $labels['label_id_unknown']['id'],
                        'label_id_flop'                         => $labels['label_id_flop']['id'],
                        'label_id_referral_new'                 => $labels['label_id_referral_new']['id'],
                        'label_id_referral_reached_out'         => $labels['label_id_referral_reached_out']['id'],
                        'label_id_check_in'                     => $labels['label_id_check_in']['id'],
                        'label_id_check_in_jan'                 => $labels['label_id_check_in_jan']['id'],
                        'label_id_check_in_feb'                 => $labels['label_id_check_in_feb']['id'],
                        'label_id_check_in_mar'                 => $labels['label_id_check_in_mar']['id'],
                        'label_id_check_in_apr'                 => $labels['label_id_check_in_apr']['id'],
                        'label_id_check_in_may'                 => $labels['label_id_check_in_may']['id'],
                        'label_id_check_in_jun'                 => $labels['label_id_check_in_jun']['id'],
                        'label_id_check_in_jul'                 => $labels['label_id_check_in_jul']['id'],
                        'label_id_check_in_aug'                 => $labels['label_id_check_in_aug']['id'],
                        'label_id_check_in_sep'                 => $labels['label_id_check_in_sep']['id'],
                        'label_id_check_in_oct'                 => $labels['label_id_check_in_oct']['id'],
                        'label_id_check_in_nov'                 => $labels['label_id_check_in_nov']['id'],
                        'label_id_check_in_dec'                 => $labels['label_id_check_in_dec']['id'],
                        'label_id_closed_lost_retired'          => $labels['label_id_closed_lost_retired']['id'],
                        'label_id_closed_lost_out_of_territory' => $labels['label_id_closed_lost_out_of_territory']['id'],
                        'label_id_meeting_scheduled'            => $labels['label_id_meeting_scheduled']['id'],
                        'label_id_rescheduled'                  => $labels['label_id_rescheduled']['id'],
                        'label_id_client_collateral'            => $labels['label_id_client_collateral']['id'],
                        'label_id_need_phone_no'                => $labels['label_id_need_phone_no']['id'],
                        'label_id_waiting_on_client_response'   => $labels['label_id_waiting_on_client_response']['id'],
                        'label_id_out_of_office'                => $labels['label_id_out_of_office']['id'],
                    ]
                );
            }

            GmailEvent::captureGmailCalendarColorData($accountId);
            Route::setFlash('success', 'Gmail account successfully connected');
        } catch (Exception $e) {
            Route::setFlash('danger', $e->getMessage());
        }

        header('Location: /clients/edit/' . $clientId);
        exit;
        break;

    case 'disconnect':
        $accountId = Route::uriParam('accountId');

        $account   = Db::fetch(
            'SELECT * FROM `sap_client_account_gmail` WHERE `id` = :id',
            ['id' => $accountId]
        );


        try {
            $client = new Google_Client();
            $client->setApplicationName(GOOGLE_APP);
            $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
            $client->setAccessToken(json_decode($account['access_token'], true));
            $client->revokeToken();
        } catch (\Exception $e) {

        }

        Db::query(
            'UPDATE `sap_client_account_gmail`
                SET `status` = "disconnected",
                    `disconnect_reason` = "Manually disconnected"
              WHERE `id` = :id',
            ['id' => $accountId]
        );

        Route::setFlash('success', 'Gmail account ' . $account['email'] . ' disconnected');

        header('Location: /clients/edit/' . $account['client_id']);
        break;

    case 'scan':
        $accountId = Route::uriParam('accountId');
        $account   = Db::fetch(
            'SELECT * FROM `sap_client_account_gmail` WHERE `id` = :id',
            ['id' => $accountId]
        );

        exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/sync-inbox.php ' . $accountId . '  > /dev/null 2>&1 &');

        header('Location: /clients/edit/' . $account['client_id']);
        break;

    case 'delete':
        $accountId = Route::uriParam('accountId');
        $account   = Db::fetch(
            'SELECT * FROM `sap_client_account_gmail` WHERE `id` = :id',
            ['id' => $accountId]
        );

        try {
            $client = new Google_Client();
            $client->setApplicationName(GOOGLE_APP);
            $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
            $client->setAccessToken(json_decode($account['access_token'], true));
            $client->revokeToken();
        } catch (\Exception $e) {

        }

        try {
            Db::query(
                'DELETE FROM `sap_client_account_gmail` WHERE `id` = :id',
                ['id' => $accountId]
            );
            Route::setFlash('success', 'Gmail account ' . $account['email'] . ' deleted');
        } catch (\Exception $e) {
            Route::setFlash('danger', 'An error occurred: ' . $e->getMessage());
        }

        header('Location: /clients/edit/' . $account['client_id']);
        break;
        
    case 'update-survey-email':
        $accountId = Route::uriParam('accountId');
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `survey_email` = :survey_email WHERE `id` = :id',
            [
                'survey_email' => empty($_POST['email']) ? null : $_POST['email'],
                'id'           => $accountId
            ]
        );
        jsonSuccess();
        break;

    case 'update-survey-results-email':
        $accountId = Route::uriParam('accountId');
        Db::query(
            'UPDATE `sap_client_account_gmail` SET `survey_results_email` = :survey_results_email WHERE `id` = :id',
            [
                'survey_results_email' => empty($_POST['email']) ? null : $_POST['email'],
                'id'                   => $accountId
            ]
        );
        jsonSuccess();
        break;

    default:
        throw new Exception ('Unknown action');
        break;
}

exit;