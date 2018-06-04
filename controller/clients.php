<?php

use Sapper\Api\Outreach;
use Sapper\Api\ProsperworksProvider;
use Sapper\Db;
use Sapper\GmailEvent;
use Sapper\Route;
use Sapper\User;
use Sapper\Util;

// permissions
if (!User::can('manage-clients')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

if (!empty($_POST['date_apply'])) {
    $date_start = Util::convertDate($_POST['date_start'], 'm/d/Y', 'Y-m-d');
    $date_end = Util::convertDate($_POST['date_end'], 'm/d/Y', 'Y-m-d');

    $date_end = date('Y-m-d', strtotime($date_end . ' +1 day'));

    $date_start .= ' 05:00:00';
    $date_end .= ' 04:59:59';
} else {
    $date_start = date('Y-m-d', strtotime('today - 30 days')) . ' 05:00:00';
    $date_end = date('Y-m-d') . ' 04:59:59';
}

// handle submissions
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    switch (Route::uriParam('action')) {
        case 'ajax-update-status':
            try {
                $query = Db::updateRowById('client', $_POST['client'], ['status' => $_POST['status']]);
                Route::setFlash('success', 'Client successfully saved');
            } catch (Exception $e) {}
        exit;
        break;
        case 'create':
            try {
                $clientId = Db::createRow(
                    'client',
                    [
                        'name'            => $_POST['name'],
                        'user_id'         => $_POST['user_id'],
                        'prosperworks_id' => $_POST['prosperworks_id'],
                    ]
                );

                // Add a new assignment
                Db::query(
                    'INSERT INTO `sap_client_assignment` (`user_id`, `client_id`) VALUES (:userId, :clientId)',
                    [
                        'userId' => $_POST['user_id'],
                        'clientId' => $clientId,
                    ]
                );



                Route::setFlash('success', 'Client successfully created');
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {
                    Route::setFlash('danger', 'Client name already in use', $_POST);
                }  elseif (false !== strpos($e->getMessage(), 'FOREIGN KEY (`user_id`)')) {
                    Route::setFlash('danger', 'You must select a CMS', $_POST);
                }

                header('Location: /clients');
                exit;
            }

            header('Location: /clients/edit/' . $clientId);
            exit;
            break;

        case 'edit':
            try {
                $clientId = Route::uriParam('id');

                $originalClient = Db::fetch(
                    'SELECT * FROM `sap_client` WHERE `id` = :id',
                    ['id' => $clientId]
                );

                $client = Db::fetch(
                    'SELECT `name`, `sign_on_date`, `launch_date`, `expiration_date`, `contract_goal`, `monthly_goal` FROM `sap_client` WHERE `id` = :id',
                    ['id' => $clientId]
                );

                $data = [
                    'name'            => $_POST['name'],
                    'status'          => $_POST['status'],
                    'user_id'         => $_POST['user_id'],
                    'sign_on_date'    => empty($_POST['sign_on_date']) ? null : Util::convertDate($_POST['sign_on_date']),
                    'launch_date'     => empty($_POST['launch_date']) ? null : Util::convertDate($_POST['launch_date']),
                    'expiration_date' => empty($_POST['expiration_date']) ? null : Util::convertDate($_POST['expiration_date']),
                    'contract_goal'   => empty($_POST['contract_goal']) ? null : $_POST['contract_goal'],
                    'monthly_goal'    => empty($_POST['monthly_goal']) ? null : $_POST['monthly_goal'],
                    'prosperworks_id' => empty($_POST['prosperworks_id']) ? null : $_POST['prosperworks_id'],
                ];

                Db::updateRowById('client', $clientId, $data);

                unset($data['user_id']);

                // If at least one of the fields has changed
                if (!empty(array_diff($client, $data))) {
                    Db::createRow(
                        'client_history',
                        array_merge(
                            $data,
                            ['client_id' => $clientId]
                        )
                    );
                }

                // End the current assignment if CSM user has changed
                if ($originalClient['user_id'] != $_POST['user_id']) {
                    Db::query(
                        'UPDATE `sap_client_assignment` SET `ends_at` = NOW() WHERE `client_id` = :clientId and `ends_at` IS NULL ',
                        ['clientId' => $clientId]
                    );

                    // Add a new assignment
                    Db::query(
                        'INSERT INTO `sap_client_assignment` (`user_id`, `client_id`) VALUES (:userId, :clientId)',
                        [
                            'userId' => $_POST['user_id'],
                            'clientId' => $clientId,
                        ]
                    );
                }

                Route::setFlash('success', 'Client successfully saved');
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {
                    Route::setFlash('danger', 'Client name already in use', $_POST, 'client');

                    header('Location: /clients/edit/' . Route::uriParam('id'));
                    exit;
                } else {
                    throw $e;
                }
            }

            header('Location: /clients');
            exit;
            break;


        case 'healthscore':
            $clientId = Route::uriParam('id');
            $meeting_year = $_POST['meeting_year'];

            if (!empty($meeting_year)) {
                $_SESSION['meeting_year'] = $meeting_year;
            }

            try {
                if (array_key_exists('score_id', $_POST) AND !empty($_POST['score_id'])) {
                    Db::query(
                        'UPDATE `sap_client_health_score`
                            SET `deal_closed` = :deal_closed, `deal_closed_av` = :deal_closed_av, `weeks_ago` = :weeks_ago, `weeks_ago_av` = :weeks_ago_av, `total_meetings` = :total_meetings, `total_meetings_av` = :total_meetings_av,
                                `contract_meetings` = :contract_meetings, `contract_meetings_av` = :contract_meetings_av, `total_weeks` = :total_weeks, `total_weeks_av` = :total_weeks_av,
                                `weeks_last_meeting` = :weeks_last_meeting, `weeks_last_meeting_av` = :weeks_last_meeting_av, `opp_in_progress` = :opp_in_progress, `opp_in_progress_av` = :opp_in_progress_av,
                                `right_prospect_noip` = :right_prospect_noip, `right_prospect_noip_av` = :right_prospect_noip_av, `wrong_prospect_oip` = :wrong_prospect_oip, `wrong_prospect_oip_av` = :wrong_prospect_oip_av,
                                `wrong_prospect` = :wrong_prospect, `wrong_prospect_av` = :wrong_prospect_av, `no_prospect` = :no_prospect, `no_prospect_av` = :no_prospect_av,
                                `impression_score` = :impression_score, `status` = :status,
                                `modified_at` = :modified_at
                        WHERE `client_id` = :client_id AND year = :meeting_year',
                        [
                            'deal_closed'            => $_POST['deal_closed'],
                            'deal_closed_av'            => $_POST['deal_closed_av'],
                            'weeks_ago'            => $_POST['weeks_ago'],
                            'weeks_ago_av'            => $_POST['weeks_ago_av'],
                            'total_meetings'            => $_POST['total_meetings'],
                            'total_meetings_av'            => $_POST['total_meetings_av'],
                            'contract_meetings'            => $_POST['contract_meetings'],
                            'contract_meetings_av'            => $_POST['contract_meetings_av'],
                            'total_weeks'   => $_POST['total_weeks'],
                            'total_weeks_av'   => $_POST['total_weeks_av'],
                            'weeks_last_meeting'   => $_POST['weeks_last_meeting'],
                            'weeks_last_meeting_av'   => $_POST['weeks_last_meeting_av'],
                            'opp_in_progress'   => $_POST['opp_in_progress'],
                            'opp_in_progress_av'   => $_POST['opp_in_progress_av'],
                            'right_prospect_noip'   => $_POST['right_prospect_noip'],
                            'right_prospect_noip_av'   => $_POST['right_prospect_noip_av'],
                            'wrong_prospect_oip'   => $_POST['wrong_prospect_oip'],
                            'wrong_prospect_oip_av'   => $_POST['wrong_prospect_oip_av'],
                            'wrong_prospect'   => $_POST['wrong_prospect'],
                            'wrong_prospect_av'   => $_POST['wrong_prospect_av'],
                            'no_prospect'   => $_POST['no_prospect'],
                            'no_prospect_av'   => $_POST['no_prospect_av'],
                            'impression_score'   => $_POST['impression_score'],
                            'status'   => 'Active',
                            'modified_at'   => Util::convertDate(date("m/d/Y")),
                            'client_id'              => $clientId,
                            'meeting_year'              => $meeting_year
                        ]
                    );
                } else {
                    $scoreId = Db::insert(
                        'INSERT INTO sap_client_health_score (
                                `client_id`,`year`,`deal_closed`,`deal_closed_av`,`weeks_ago`,`weeks_ago_av`,`total_meetings`,`total_meetings_av`,
                                `contract_meetings`,`contract_meetings_av`,
                                `total_weeks`,`total_weeks_av`,`weeks_last_meeting`,`weeks_last_meeting_av`,
                                `opp_in_progress`, `opp_in_progress_av`, `right_prospect_noip`, `right_prospect_noip_av`,
                                `wrong_prospect_oip`,`wrong_prospect_oip_av`,`wrong_prospect`,`wrong_prospect_av`,
                                `no_prospect`,`no_prospect_av`,`impression_score`,
                                `status`,`created_at`)
                            VALUES (
                                :client_id,:meeting_year,:deal_closed,:deal_closed_av,:weeks_ago,:weeks_ago_av,:total_meetings,:total_meetings_av,
                                :contract_meetings,:contract_meetings_av,
                                :total_weeks,:total_weeks_av,:weeks_last_meeting,:weeks_last_meeting_av,
                                :opp_in_progress,:opp_in_progress_av,:right_prospect_noip,:right_prospect_noip_av,
                                :wrong_prospect_oip,:wrong_prospect_oip_av,:wrong_prospect,:wrong_prospect_av,
                                :no_prospect,:no_prospect_av,:impression_score,
                                :status,:created_at)',
                        [
                            'client_id' => (int) $clientId,
                            'meeting_year'              => $meeting_year,
                            'deal_closed'    => $_POST['deal_closed'],
                            'deal_closed_av'    => $_POST['deal_closed_av'],
                            'weeks_ago'    => (int) $_POST['weeks_ago'],
                            'weeks_ago_av'    => (int) $_POST['weeks_ago_av'],
                            'total_meetings'  => (int) $_POST['total_meetings'],
                            'total_meetings_av'  => (int) $_POST['total_meetings_av'],
                            'contract_meetings'  => (int) $_POST['contract_meetings'],
                            'contract_meetings_av'  => (int) $_POST['contract_meetings_av'],
                            'total_weeks'  => (int) $_POST['total_weeks'],
                            'total_weeks_av'  => (int) $_POST['total_weeks_av'],
                            'weeks_last_meeting'  => (int) $_POST['weeks_last_meeting'],
                            'weeks_last_meeting_av'  => (int) $_POST['weeks_last_meeting_av'],
                            'opp_in_progress'  => (int) $_POST['opp_in_progress'],
                            'opp_in_progress_av'  => (int) $_POST['opp_in_progress_av'],
                            'right_prospect_noip'  => (int) $_POST['right_prospect_noip'],
                            'right_prospect_noip_av'  => (int) $_POST['right_prospect_noip_av'],
                            'wrong_prospect_oip'  => (int) $_POST['wrong_prospect_oip'],
                            'wrong_prospect_oip_av'  => (int) $_POST['wrong_prospect_oip_av'],
                            'wrong_prospect'  => (int) $_POST['wrong_prospect'],
                            'wrong_prospect_av'  => (int) $_POST['wrong_prospect_av'],
                            'no_prospect'  => (int) $_POST['no_prospect'],
                            'no_prospect_av'  => (int) $_POST['no_prospect_av'],
                            'impression_score'  => (int) $_POST['impression_score'],
                            'status'  => 'Active',
                            'created_at'  => date("Y-m-d H:i:s"),
                        ]
                    );
                }

                Route::setFlash('success', 'Client health score successfully saved');
            } catch (Exception $e) {
                throw $e;
            }

            header('Location: /clients/stats/' . $clientId);
            exit;
            break;

        case 'dne-get-data':
            $totalCount = Db::fetchColumn(
                'SELECT COUNT(*) AS `count` FROM `sap_client_dne` WHERE `client_id` = :client_id',
                ['client_id' => $_POST['id']],
                'count'
            );

            $filteredCount = Db::fetchColumn(
                'SELECT COUNT(*) AS `count`
                   FROM `sap_client_dne`
                  WHERE `client_id` = :client_id AND `domain` LIKE :domain',
                [
                    'client_id' => $_POST['id'],
                    'domain'    => '%' . $_POST['search']['value'] . '%'
                ],
                'count'
            );

            $domains = Db::fetchAll(
                'SELECT *
                   FROM `sap_client_dne`
                  WHERE `client_id` = :client_id AND `domain` LIKE :domain
               ORDER BY `domain` ASC
                  LIMIT :offset, :rowCount',
                [
                    'client_id' => (int) $_POST['id'],
                    'domain'    => '%' . $_POST['search']['value'] . '%',
                    'offset'    => (int) $_POST['start'],
                    'rowCount'  => (int) $_POST['length'],
                ]
            );

            jsonResponse(
                [
                    'draw'            => (int) $_REQUEST['draw'],
                    'domains'         => $domains,
                    'recordsTotal'    => $totalCount,
                    'recordsFiltered' => $filteredCount
                ]
            );
            break;

        case 'dne-edit':
            Db::query(
                'UPDATE `sap_client_dne` SET `domain` = :domain WHERE `id` = :id LIMIT 1',
                [
                    'domain' => $_POST['domain'],
                    'id'     => $_POST['id']
                ]
            );

            jsonResponse('success');
            break;

        case 'dne-delete':
            Db::query(
                'DELETE FROM `sap_client_dne` WHERE `id` = :id',
                ['id' => $_POST['id']]
            );
            break;

        case 'dne-add':
            try {
                Db::insert(
                    'INSERT INTO `sap_client_dne` (`client_id`, `domain`) VALUES (:client_id, :domain)',
                    [
                        'client_id' => $_POST['client_id'],
                        'domain'    => '@' . ltrim($_POST['domain'], '@')
                    ]
                );
            } catch (Exception $e) {
                //
            }

            header('Location: /clients/dne/' . $_POST['client_id']);
            exit;
            break;


        case 'dne-upload':
            $clientId = $_POST['client_id'];

            if ('replace' == $_POST['type']) {
                Db::query(
                    'DELETE FROM `sap_client_dne` WHERE `client_id` = :client_id',
                    ['client_id' => $clientId]
                );
            }

            $file = fopen($_FILES['file']['tmp_name'], 'r');
            while ($row = fgetcsv($file)) {
                $domain = ltrim(ltrim($row[0], '*'), '@');

                if (strlen($domain) > 0) {
                    try {
                        Db::insert(
                            'INSERT INTO `sap_client_dne` (`client_id`, `domain`) VALUES (:client_id, :domain)',
                            [
                                'client_id' => $clientId,
                                'domain'    => '@' . $domain
                            ]
                        );
                    } catch (Exception $e) {
                        //
                    }
                }
            }
            header('Location: /clients/dne/' . $clientId);
            exit;
            break;

        case 'profile-create':
            try {
                $profileId = Db::insert(
                    'INSERT INTO `sap_client_profile` (`client_id`, `name`, `countries`)
                     VALUES (:client_id, :name, :countries)',
                    [
                        'client_id' => Route::uriParam('client_id'),
                        'name'      => $_POST['name'],
                        'countries' => '[".io",".me",".us"]'
                    ]
                );

                Route::setFlash('success', 'Search profile successfully created');
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {

                    Route::setFlash('danger', 'Search profile name already in use', $_POST, 'profile');

                    header('Location: /clients/edit/' . Route::uriParam('client_id'));
                    exit;
                } else {
                    throw $e;
                }
            }

            header('Location: /clients/profile-edit/' . $profileId);
            exit;
            break;



        case 'profile-save':
            $profileId = Route::uriParam('profile_id');
            try {
                Db::query(
                    'UPDATE `sap_client_profile`
                        SET `name` = :name, `states` = :states, `countries` = :countries,
                            `max_prospects` = :max_prospects, `max_prospects_scope` = :max_prospects_scope,
                            `geotarget` = :geotarget, `geotarget_lat` = :geotarget_lat,
                            `geotarget_lng` = :geotarget_lng, `radius` = :radius
                      WHERE `id` = :id',
                    [
                        'name'                => $_POST['name'],
                        'states'              => array_key_exists('states', $_POST)    ? json_encode($_POST['states']) : null,
                        'countries'           => array_key_exists('countries', $_POST) ? json_encode($_POST['countries']) : null,
                        'max_prospects'       => $_POST['prospects'] ?: null,
                        'max_prospects_scope' => $_POST['prospectScope'] ?: null,
                        'geotarget'           => $_POST['geotarget'] ?: null,
                        'geotarget_lat'       => $_POST['geotarget_lat'] ?: null,
                        'geotarget_lng'       => $_POST['geotarget_lng'] ?: null,
                        'radius'              => $_POST['radius'] ?: null,
                        'id'                  => $profileId
                    ]
                );
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {

                    Route::setFlash('danger', 'Search profile name already in use', $_POST);

                    header('Location: /clients/profile-edit/' . $profileId);
                    exit;
                } else {
                    throw $e;
                }
            }

            Db::query(
                'DELETE FROM `sap_client_profile_title` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            );

            if (array_key_exists('titles', $_POST)) {
                foreach ($_POST['titles'] as $titleId) {
                    Db::insert(
                        'INSERT INTO `sap_client_profile_title` (`client_profile_id`, `title_id`)
                          VALUES (:profile_id, :title_id)',
                        [
                            'profile_id' => $profileId,
                            'title_id'   => $titleId
                        ]
                    );
                }
            }

            Db::query(
                'DELETE FROM `sap_client_profile_department` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            );

            if (array_key_exists('departments', $_POST)) {
                foreach ($_POST['departments'] as $departmentId) {
                    Db::insert(
                        'INSERT INTO `sap_client_profile_department` (`client_profile_id`, `department_id`)
                          VALUES (:profile_id, :department_id)',
                        [
                            'profile_id'    => $profileId,
                            'department_id' => $departmentId
                        ]
                    );
                }
            }

            $clientId = Db::fetchColumn(
                'SELECT `client_id` FROM `sap_client_profile` WHERE `id` = :profile_id',
                ['profile_id' => Route::uriParam('profile_id')],
                'client_id'
            );

            // update client-level targeting summary

            $profileSummaries = [];
            $profiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );


            foreach ($profiles as $profile) {
                $titlesData = Db::fetchAll(
                    'SELECT t.`name`
                       FROM `sap_client_profile_title` pt
                  LEFT JOIN `sap_group_title` t ON pt.`title_id` = t.`id`
                      WHERE pt.`client_profile_id` = :client_profile_id',
                    [
                        'client_profile_id' => $profile['id']
                    ]
                );
                $titles = [];

                foreach ($titlesData as $titleData) {
                    $titles[] = $titleData['name'];
                }

                $departmentsData = Db::fetchAll(
                    'SELECT d.`department`
                       FROM `sap_client_profile_department` pd
                  LEFT JOIN `sap_department` d ON pd.`department_id` = d.`id`
                      WHERE pd.`client_profile_id` = :client_profile_id',
                    [
                        'client_profile_id' => $profile['id']
                    ]
                );
                $departments = [];

                foreach ($departmentsData as $departmentData) {
                    $departments[] = $departmentData['department'];
                }

                $profileSummaries[] = sprintf(
                    '(%s: %s %s %s %s %s %s)',
                    $profile['name'] . ': ',
                    !empty($profile['states'])        ? '[States: '    . implode(', ', json_decode($profile['states'], true)) . ']'    : '',
                    !empty($profile['countries'])     ? '[Countries: ' . implode(', ', json_decode($profile['countries'], true)) . ']' : '',
                    !empty($profile['max_prospects']) ? '[Max Prospects: ' . $profile['max_prospects'] . ' (' . $profile['max_prospects_scope'] . ')]' : '',
                    !empty($profile['geotarget'])     ? '[Geotarget: ' . $profile['geotarget'] . '(' . $profile['radius'] . ' mi)]' : '',
                    !empty($titles)                   ? '[Titles: ' . implode(', ', $titles) . ']' : '',
                    !empty($departments)              ? '[Departments: ' . implode(', ', $departments) . ']' : ''
                );
            }


            Db::query(
                'UPDATE `sap_client` SET `target_profiles_summary` = :summary WHERE `id` = :client_id',
                [
                    'summary'   => implode(', ', $profileSummaries),
                    'client_id' => $clientId
                ]
            );

            Route::setFlash('success', 'Search profile successfully updated');
            header('Location: /clients/edit/' . $clientId);
            break;

        case 'ajax-get-eligible-survey-events':
            $extraJoin = ' LEFT JOIN `sap_survey` s ON e.`event_id` = s.`event_id` ';
            $extraCriteria = ' s.`id` IS NULL AND NOW() > e.`starts_at` ';
            $orderBy = ' e.`starts_at` DESC ';

            $dbEvents = GmailEvent::getEligibleEvents(
                $extraCriteria,
                $extraJoin,
                $orderBy,
                null,
                Route::uriParam('client_id')
            );

            $events = [];

            foreach ($dbEvents as $dbEvent) {
                $label = '';

                if (!empty($dbEvent['title'])) {
                    $label .= $dbEvent['title']. ' - ';
                }

                $label .= date('n/j/Y', strtotime($dbEvent['starts_at']));

                $events[] = ['id' => $dbEvent['id'], 'label' => $label];
            }

            jsonSuccess(['events' => $events]);

            break;

        case 'ajax-send-survey-invitation':
            $event = GmailEvent::getEligibleEvents(
                null,
                null,
                null,
                null,
                null,
                false,
                true,
                $_POST['eventId']
            );

            if (empty($event)) {
                jsonError(['message' => 'Unknown meeting']);
            }

            if (empty($event['survey_email'])) {
                jsonError(['message' => 'No survey invitation email addresses set']);
            }

            $emails = explode(',', $event['survey_email']);

            Util::sendSurveyInvitation($event, $emails);

            jsonSuccess();
            break;
    }
}

// list pages
if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'edit':
            $clientId = Route::uriParam('id');

            $meeting_year_select = !empty($_SESSION['meeting_year']) ? $_SESSION['meeting_year'] : date('Y');

            unset($_SESSION['meeting_year']);

            $client = Db::fetch(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $clientId]
            );

            $healthScores = Db::fetch(
                'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id AND `year` = :year',
                ['client_id' => $clientId, 'year' => $meeting_year_select]
            );

            $profiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            $outreachAccounts = Db::fetchAll(
                'SELECT a.*, COUNT(p.`id`) AS `num_prospects`
                   FROM `sap_client_account_outreach` a
              LEFT JOIN `sap_outreach_prospect` p ON p.`outreach_account_id` = a.`id`
                  WHERE a.`client_id` = :id
               GROUP BY a.`id`',
                ['id' => $clientId]
            );

            foreach ($outreachAccounts as $i => $outreachAccount) {
                $outreachAccounts[$i]['authUrl'] = Outreach::getAuthUrl($outreachAccount['id']);
            }

            $gmailAccounts = Db::fetchAll(
                'SELECT *
                   FROM `sap_client_account_gmail`
                  WHERE `client_id` = :id',
                ['id' => $clientId]
            );

            $monthMeetings = Db::fetch(
                'SELECT * FROM `sap_client_meetings_per_month` WHERE `client_id` = :client_id AND `year` = :year',
                ['client_id' => $clientId, 'year' => $meeting_year_select]
            );


            $meeting_years[] = date('Y',strtotime("-1 year"));
            $meeting_years[] = date('Y');

            // List of all users stored in the database to add to the CSM drop down list
            $users = Db::fetchAll(
                "
                SELECT `id` as `value`, CONCAT(`first_name`, ' ', `last_name`) as `text`
                FROM `sap_user`
                WHERE `pod_id` IS NOT NULL
                ORDER BY `text`  ASC
                "
            );

            $companies = Db::fetchAll(
                'SELECT * FROM `sap_client_prosperworks` WHERE `name` IS NOT NULL ORDER BY `name` ASC'
            );

            sapperView(
                'clients-edit',
                [
                    'client'              => $client,
                    'healthScores'        => $healthScores,
                    'profiles'            => $profiles,
                    'outreachAccounts'    => $outreachAccounts,
                    'meeting_year_select' => $meeting_year_select,
                    'meeting_years'       => $meeting_years,
                    'monthMeetings'       => $monthMeetings,
                    'gmailAccounts'       => $gmailAccounts,
                    'users'               => $users,
                    'companies'           => $companies,
                    'status'              => array('active','paused','archived') // TODO: clean up, make a constant array.
                ]
            );
            break;
        case 'stats':
            $clientId = Route::uriParam('id');

            $meeting_year_select = !empty($_SESSION['meeting_year']) ? $_SESSION['meeting_year'] : date('Y');

            unset($_SESSION['meeting_year']);

            #### Reports counts #####
            $p_created = 0;
            $p_mailed = 0;
            $p_opened = 0;
            $p_replied = 0;
            $p_bounced = 0;
            $p_unsubscribed = 0;

            $m_deliveries = 0;
            $m_oneoffs = 0;
            $m_sequences = 0;
            $m_opens = 0;
            $m_replies = 0;
            $m_bounces = 0;
            $m_unsubscribes = 0;
            #### Reports counts #####

            $client = Db::fetch(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $clientId]
            );

            $healthScores = Db::fetch(
                'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id AND `year` = :year',
                ['client_id' => $clientId, 'year' => $meeting_year_select]
            );

            $profiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            $gmail_accounts = Db::fetchAll(
                'SELECT * FROM `sap_client_account_gmail` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            $totalMeetings = 0;
            if (!empty($gmail_accounts)) {
                foreach ($gmail_accounts as $gmail_account) {
                    $sqlTotalMeetings = 'SELECT count(*) AS totalMeetings
                    FROM   (((`sap_gmail_events` `e`
                                              LEFT JOIN `sap_client_account_gmail` `a`
                                                             ON(( `e`.`account_id` = `a`.`id` )))
                                             LEFT JOIN `sap_client` `c`
                                                            ON(( `a`.`client_id` = `c`.`id` )))
                                            LEFT JOIN `sap_prospect` `p`
                                                       ON(( `e`.`prospect_id` = `p`.`id` )))
                    WHERE  ( 1=1 )
                    AND `a`.`id` = :account_id
                    AND month(`e`.`created_at`) = ' . date('m') . '
                    AND `e`.`title` != "Available"
                    AND DATE_FORMAT(`e`.`ends_at`, "%H:%i:%s") != "00:00:00"
                    GROUP BY `c`.`id`
                    ORDER by `c`.`id` DESC';

                    $rsTotalMeetings = Db::fetch(
                            $sqlTotalMeetings,
                            ['account_id' => $gmail_account['id']]
                    );

                    $totalMeetings += !empty($rsTotalMeetings['totalMeetings']) ? (int)$rsTotalMeetings['totalMeetings'] : 0;
                }
            }

            $outreachAccounts = Db::fetchAll(
                'SELECT a.*, COUNT(p.`id`) AS `num_prospects`
                   FROM `sap_client_account_outreach` a
              LEFT JOIN `sap_outreach_prospect` p ON p.`outreach_account_id` = a.`id`
                  WHERE a.`client_id` = :id
               GROUP BY a.`id`',
                ['id' => $clientId]
            );

            foreach ($outreachAccounts as $i => $outreachAccount) {
                $outreachAccounts[$i]['authUrl'] = Outreach::getAuthUrl($outreachAccount['id']);
            }

            $gmailAccounts = Db::fetchAll(
                'SELECT *
                   FROM `sap_client_account_gmail`
                  WHERE `client_id` = :id',
                ['id' => $clientId]
            );

            $monthMeetings = Db::fetch(
                'SELECT * FROM `sap_client_meetings_per_month` WHERE `client_id` = :client_id AND `year` = :year',
                ['client_id' => $clientId, 'year' => $meeting_year_select]
            );

            $meeting_years[] = date('Y',strtotime("-1 year"));
            $meeting_years[] = date('Y');

            sapperView(
                'clients-stats',
                [
                    'client'           => $client,
                    'healthScores'           => $healthScores,
                    'comments1'           => $comments1,
                    'comments2'           => $comments2,
                    'comments3'           => $comments3,
                    'comments4'           => $comments4,
                    'profiles'         => $profiles,
                    'outreachAccounts' => $outreachAccounts,
                    'monthMeetings' => $monthMeetings,
                    'totalMeetings' => $totalMeetings,
                    'gmailAccounts'    => $gmailAccounts,
                    'date_start'    => $date_start,
                    'date_end'    => $date_end,

                    'p_created' => $p_created,
                    'p_mailed' => $p_mailed,
                    'p_opened' => $p_opened,
                    'p_replied' => $p_replied,
                    'p_bounced' => $p_bounced,
                    'p_unsubscribed' => $p_unsubscribed,

                    'm_deliveries' => $m_deliveries,
                    'm_oneoffs' => $m_oneoffs,
                    'm_sequences' => $m_sequences,
                    'm_opens' => $m_opens,
                    'm_replies' => $m_replies,
                    'm_bounces' => $m_bounces,
                    'm_unsubscribes' => $m_unsubscribes,
                    'meeting_year_select' => $meeting_year_select,
                    'meeting_years' => $meeting_years,
                ]
            );
            break;
        case 'outreach-reports':
            $clientId = Route::uriParam('id');

            $client = Db::fetch(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => $clientId]
            );

            $healthScores = Db::fetch(
                'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            $profiles = Db::fetchAll(
                'SELECT * FROM `sap_client_profile` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            $outreachAccounts = Db::fetchAll(
                'SELECT a.*, COUNT(p.`id`) AS `num_prospects`
                   FROM `sap_client_account_outreach` a
              LEFT JOIN `sap_outreach_prospect` p ON p.`outreach_account_id` = a.`id`
                  WHERE a.`client_id` = :id
               GROUP BY a.`id`',
                ['id' => $clientId]
            );

            foreach ($outreachAccounts as $i => $outreachAccount) {
                $outreachAccounts[$i]['authUrl'] = Outreach::getAuthUrl($outreachAccount['id']);
            }

            $gmailAccounts = Db::fetchAll(
                'SELECT *
                   FROM `sap_client_account_gmail`
                  WHERE `client_id` = :id',
                ['id' => $clientId]
            );

            $monthMeetings = Db::fetch(
                'SELECT * FROM `sap_client_meetings_per_month` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            #### Reports counts #####
            $date_start = date('Y-09-30');
            $date_end = date('Y-m-t');
            $p_created = 0;
            $p_mailed = 0;
            $p_opened = 0;
            $p_replied = 0;
            $p_bounced = 0;
            $p_unsubscribed = 0;

            $m_deliveries = 0;
            $m_oneoffs = 0;
            $m_sequences = 0;
            $m_opens = 0;
            $m_replies = 0;
            $m_bounces = 0;
            $m_unsubscribes = 0;
            #### Reports counts #####

            sapperView(
                'clients-outreach-reports',
                [
                    'client'           => $client,
                    'healthScores'           => $healthScores,
                    'profiles'         => $profiles,
                    'outreachAccounts' => $outreachAccounts,
                    'monthMeetings' => $monthMeetings,
                    'gmailAccounts'    => $gmailAccounts,

                    'p_created' => $p_created,
                    'p_mailed' => $p_mailed,
                    'p_opened' => $p_opened,
                    'p_replied' => $p_replied,
                    'p_bounced' => $p_bounced,
                    'p_unsubscribed' => $p_unsubscribed,

                    'm_deliveries' => $m_deliveries,
                    'm_oneoffs' => $m_oneoffs,
                    'm_sequences' => $m_sequences,
                    'm_opens' => $m_opens,
                    'm_replies' => $m_replies,
                    'm_bounces' => $m_bounces,
                    'm_unsubscribes' => $m_unsubscribes,
                ]
            );
            break;
        case 'hsedit':
            $clientId = Route::uriParam('id');
			$field = $_POST['name'];
			$value = $_POST['value'];

            $healthScores = Db::fetch(
                'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            if (!empty($healthScores)) {
                    # Updating health score

                    if ($field == 'deal_closed') {
                            $field_sql = '`deal_closed` = :deal_closed';
                    } else if ($field == 'weeks_ago') {
                            $field_sql = '`weeks_ago` = :weeks_ago';
                    } else if ($field == 'impression_score') {
                            $field_sql = '`impression_score` = :impression_score';
                    }

                    $sql = 'UPDATE `sap_client_health_score`
                                            SET '.$field_sql.',
                                                    `modified_at` = :modified_at
                                    WHERE `client_id` = :client_id';

                    Db::query(
                            $sql,
                            [
                                    $field => $value,
                                    'modified_at' => date("Y-m-d H:i:s"),
                                    'client_id' => $clientId
                            ]
                    );
            } else {
                    # Inserting health score

                    $scoreId = Db::insert(
                            'INSERT INTO sap_client_health_score (
                                            `client_id`,`'.$field.'`,
                                            `status`,`created_at`)
                                    VALUES (
                                            :client_id,:'.$field.',
                                            :status,:created_at)',
                            [
                                    'client_id' => (int) $clientId,
                                    $field    => $value,
                                    'status'  => 'Active',
                                    'created_at'  => date("Y-m-d H:i:s"),
                            ]
                    );
            }


            exit;
            break;
        case 'csm':
            $clientId = Route::uriParam('id');
			$field = $_POST['name'];

            if ($field != 'csm_user_id') {
                // This should never be the case, so we just exit;
                exit;
            }
            $userId = intval($_POST['value']);

            if($userId > 0) {
                // Fetch the current CSM to check if it is being changed
                $currentUserId = Db::fetchColumn(
                    "SELECT user_id FROM `sap_client` WHERE `id` = :id",
                    ['id' => $clientId],
                    'user_id'
                );

                if($userId != $currentUserId) {
                    // End the current assignment
                    Db::query(
                        'UPDATE `sap_client_assignment` SET `ends_at` = NOW() WHERE `client_id` = :clientId and `ends_at` IS NULL ',
                        ['clientId' => $clientId]
                    );

                    // Add a new assignment
                    Db::query(
                        'INSERT INTO `sap_client_assignment` (`user_id`, `client_id`) VALUES (:userId, :clientId)',
                        [
                            'userId' => $userId,
                            'clientId' => $clientId,
                        ]
                    );

                    // Update the csm in sap_client table
                    Db::query(
                        'UPDATE `sap_client` SET `user_id` = :userId WHERE `id` = :clientId',
                        [
                            'userId' => $userId,
                            'clientId' => $clientId,
                        ]
                    );

                    // We need to return the value of the new pod, so we can display it in the clients list
                    $pod = Db::fetchColumn(
                        'SELECT p.`name` as pod FROM `sap_client` c
                         LEFT JOIN `sap_user` u ON c.`user_id` = u.`id`
                         LEFT JOIN `sap_pod` p ON u.`pod_id` = p.`id`
                         WHERE c.`id` = :clientId',
                        ['clientId' => $clientId],
                        'pod'
                    );

                    echo $pod;
                }
            }

            exit;
            break;
		case 'ajax-get-healthscore':
            $clientId = $_POST['client_id'];

            $healthScore = Db::fetch(
                'SELECT * FROM `sap_client_health_score` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            echo json_encode($healthScore);
            exit;
            break;
        case 'ajax-update-month-meetings':
            $clientId = $_POST['client_id'];
            $meetings = $_POST['meetings'];
            $meeting_year = $_POST['meeting_year'];

            $meetings_jan = !empty($meetings[0]) ? $meetings[0] : 0;
            $meetings_feb = !empty($meetings[1]) ? $meetings[1] : 0;
            $meetings_mar = !empty($meetings[2]) ? $meetings[2] : 0;
            $meetings_apr = !empty($meetings[3]) ? $meetings[3] : 0;
            $meetings_may = !empty($meetings[4]) ? $meetings[4] : 0;
            $meetings_jun = !empty($meetings[5]) ? $meetings[5] : 0;
            $meetings_jul = !empty($meetings[6]) ? $meetings[6] : 0;
            $meetings_aug = !empty($meetings[7]) ? $meetings[7] : 0;
            $meetings_sep = !empty($meetings[8]) ? $meetings[8] : 0;
            $meetings_oct = !empty($meetings[9]) ? $meetings[9] : 0;
            $meetings_nov = !empty($meetings[10]) ? $meetings[10] : 0;
            $meetings_dec = !empty($meetings[11]) ? $meetings[11] : 0;

            $month_meetings = Db::fetch(
                'SELECT * FROM `sap_client_meetings_per_month` WHERE `client_id` = :client_id AND `year` = :year',
                ['client_id' => $clientId, 'year'=>$meeting_year]
            );

            if ($month_meetings) {
                try {
                    $sql = '';

                    $sql .= 'UPDATE `sap_client_meetings_per_month`';
                    $sql .= ' SET ';
                    $sql .= "`meetings_jan` = {$meetings_jan},";
                    $sql .= "`meetings_feb` = {$meetings_feb},";
                    $sql .= "`meetings_mar` = {$meetings_mar},";
                    $sql .= "`meetings_apr` = {$meetings_apr},";
                    $sql .= "`meetings_may` = {$meetings_may},";
                    $sql .= "`meetings_jun` = {$meetings_jun},";
                    $sql .= "`meetings_jul` = {$meetings_jul},";
                    $sql .= "`meetings_aug` = {$meetings_aug},";
                    $sql .= "`meetings_sep` = {$meetings_sep},";
                    $sql .= "`meetings_oct` = {$meetings_oct},";
                    $sql .= "`meetings_nov` = {$meetings_nov},";
                    $sql .= "`meetings_dec` = {$meetings_dec}";
                    $sql .= " WHERE `client_id` = {$clientId} AND `year` = {$meeting_year}";

                    Db::query($sql);
                    Route::setFlash('success', 'Client successfully saved');
                } catch (Exception $e) {
                    echo  $e->getMessage();
                }
            } else {
                try {
                    $sql = '';

                    $sql .= 'INSERT INTO `sap_client_meetings_per_month`';
                    $sql .= ' (year,meetings_jan,meetings_feb,meetings_mar,meetings_apr,meetings_may,meetings_jun,meetings_jul,meetings_aug,meetings_sep,meetings_oct,meetings_nov,meetings_dec, client_id) ';
                    $sql .= " VALUES ({$meeting_year},{$meetings_jan},{$meetings_feb},{$meetings_mar},{$meetings_apr},{$meetings_may},{$meetings_jun},{$meetings_jul},{$meetings_aug},{$meetings_sep},{$meetings_oct},{$meetings_nov},{$meetings_dec},{$clientId})";

                    Db::query($sql);
                } catch (Exception $e) {
                     echo  $e->getMessage();
                }
            }

            $response['total_meetings_av'] = array_sum($meetings);
            $response['status'] = 'success';


            echo json_encode($response);
            exit;
            break;
        case 'ajax-set-session-data':
            $meeting_year = !empty($_POST['meeting_year']) ? $_POST['meeting_year'] : date('Y');
            $_SESSION['meeting_year'] = $meeting_year;

            exit;
            break;
        case 'ajax-stats-get-mcr':
            $response = [];
            $client_id = $_POST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $mailed_count = 0;
                $bounced_count = 0;
                $total_meetings_counts = 0;
                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $access_token = $outreachAccount['access_token'];

                        $sql = "SELECT
                                        *
                                      FROM
                                        `sap_prospect_mailings`
                                      WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                        AND state != 'bounced'
                                        AND prospect_id != 0
                                        AND (delivered_at BETWEEN '$date_start' AND '$date_end')
                                        GROUP BY prospect_id";
                        $count_arr = Db::fetchAll(
                            $sql
                        );

                        $mailed_count += count($count_arr);

                        ## $mailed_count += count($mailed_count_arr);
                    }
                }

                $sqlTotalMeetings = "SELECT count(*) AS totalMeetings
                    FROM   (((`sap_gmail_events` `e`
                                    LEFT JOIN `sap_client_account_gmail` `a`
                                                   ON(( `e`.`account_id` = `a`.`id` )))
                                   LEFT JOIN `sap_client` `c`
                                                  ON(( `a`.`client_id` = `c`.`id` )))
                                  LEFT JOIN `sap_prospect` `p`
                                             ON(( `e`.`prospect_id` = `p`.`id` )))
                    WHERE  ( 1=1 )
                    AND `c`.`id` = :client_id
                    AND (`e`.`created_at` BETWEEN '" . $date_start . "' AND '" . $date_end . "')
                    AND `e`.`title` != 'Available'
                    AND DATE_FORMAT(`e`.`ends_at`, '%H:%i:%s') != '00:00:00'
                    GROUP BY `c`.`id`";

                $rsTotalMeetings = Db::fetch(
                    $sqlTotalMeetings,
                    ['client_id' => $client_id]
                );

                $total_meetings_counts = !empty($rsTotalMeetings['totalMeetings']) ? (int)$rsTotalMeetings['totalMeetings'] : 0;

                $response['status'] = 'success';
                $response['meta'] = "($mailed_count / $total_meetings_counts)";

                $mcr = !empty($mailed_count) ? ($total_meetings_counts / $mailed_count) * 100 : 0;
                $response['mcr'] = round($mcr, 2);
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['mcr'] = 0;
                $response['message'] = $exc->getMessage();
            }

            echo json_encode($response);
            break;
        case 'ajax-stats-get-inbox-counts':
            $response = [];
            $inbox_counts = [];

            $client_id = $_REQUEST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            $accounts = Db::fetchAll(
                'SELECT * FROM `sap_client_account_gmail` WHERE `client_id` = :client_id',
                ['client_id' => $client_id]
            );

            if (!empty($accounts)) {
                foreach ($accounts as $account) {
                    $account_stats = Db::fetch(
                        "SELECT label_count_scheduling_in_progress,"
                            . "label_count_reschedule_cancel,"
                            . "label_count_referral,"
                            . "label_count_closed_lost,"
                            . "label_count_bad_email,"
                            . "label_count_unknown,"
                            . "label_count_confused,"
                            . "label_count_check_back_in_now,"
                            . "label_count_check_back_in_1_month,"
                            . "label_count_check_back_in_2_months,"
                            . "label_count_check_back_in_3_months,"
                            . "label_count_check_back_in_4_months,"
                            . "label_count_check_back_in_6_months,"
                            . "label_count_check_back_in_8_months,"
                            . "label_count_check_back_in_12_months,"
                            . "label_count_not_interested_fup,"
                            . "label_count_meeting_in_progress_fup,"
                            . "label_count_rescheduled_fup "
                            . "FROM `sap_gmail_account_stats` "
                            . "WHERE `gmail_account_id` = '{$account['id']}'"
                    );

                    if (!empty($account_stats)) {
                        foreach ($account_stats as $col=>$counts) {
                            if (strpos($col,'label') !== false) {
                                $label_counts = '';

                                $label_counts['name'] = ucwords(str_replace('_',' ',str_replace('label_count_','',$col)));
                                $label_counts['y'] = $counts;

                                $inbox_counts[] = $label_counts;
                            }
                        }
                    }
                }
            }

            $response['status'] = 'success';
            $response['inbox_counts'] = $inbox_counts;

            echo json_encode($response);
            break;
        case 'ajax-stats-get-avg-openrate':
            $response = [];

            $client_id = $_REQUEST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $opened_count = 0;
                $mailed_count = 0;
                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $access_token = $outreachAccount['access_token'];

                        $sql_opened = "SELECT
                                        *
                                      FROM
                                        `sap_prospect_mailings`
                                      WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                        AND state != 'bounced'
                                        AND prospect_id != 0
                                        AND (date_format(opened_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                        AND (date_format(delivered_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                        GROUP BY prospect_id";
                        $opened_count_arr = Db::fetchAll(
                            $sql_opened
                        );

                        $opened_count += count($opened_count_arr);

//                        $params['filter[deliveredAt]'] = date('Y-m-01') . ".." . date('Y-m-t');
//                        $response_mailed = Outreach::call(
//                            'mailings',
//                            $params,
//                            $access_token,
//                            'get',
//                            Outreach::URL_REST_v2
//                        );
//
//                        $mailed_count += $response_mailed['data']['meta']['count'];
//                        $sql_mailed = "SELECT
//                                        count(*) AS mailed_count
//                                      FROM
//                                        `sap_prospect_mailings`
//                                      WHERE `outreach_account_id` = '{$outreachAccount['id']}'
//                                        AND month(`created_at`) = " . date('m');
//                        $mailed_count_arr = Db::fetch(
//                            $sql_mailed
//                        );
//                        $mailed_count += $mailed_count_arr['mailed_count'];

                        $sql = "SELECT
                                        *
                                      FROM
                                        `sap_prospect_mailings`
                                      WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                        AND state != 'bounced'
                                        AND prospect_id != 0
                                        AND (date_format(delivered_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                        GROUP BY prospect_id";
                        $count_arr = Db::fetchAll(
                            $sql
                        );

                        $mailed_count += count($count_arr);

                    }

                }
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['average_openrate'] = 0;
                $response['message'] = $exc->getMessage();
            }

            $response['status'] = 'success';
            $response['average_openrate'] = !empty($mailed_count) ? round(($opened_count / $mailed_count) * 100) : 0;

            echo json_encode($response);
            break;
        case 'ajax-stats-get-avg-replyrate':
            $response = [];
            $client_id = $_POST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $replied_count = 0;
                $mailed_count = 0;

                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $access_token = $outreachAccount['access_token'];

                            $sql = "    SELECT
                                            *
                                        FROM
                                            `sap_prospect_mailings`
                                        WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                            AND state = 'replied'
                                            AND (date_format(created_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                            AND (date_format(replied_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')";
                            $count_arr = Db::fetchAll(
                                $sql
                            );

                            $replied_count += count($count_arr);

                            $sql = "SELECT
                                            *
                                          FROM
                                            `sap_prospect_mailings`
                                          WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                            AND state != 'bounced'
                                            AND prospect_id != 0
                                            AND (date_format(delivered_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                            GROUP BY prospect_id";
                            $count_arr = Db::fetchAll(
                                $sql
                            );

                            $mailed_count += count($count_arr);
                    }
                }
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['average_replyrate'] = 0;
                $response['message'] = $exc->getMessage();
            }

            $response['status'] = 'success';
            $response['average_replyrate'] = !empty($mailed_count) ? round(($replied_count / $mailed_count) * 100, 2) : 0;

            echo json_encode($response);
            break;
        case 'ajax-stats-get-no-prospects-bounced':
            $response = [];
            $client_id = $_POST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');
            $counts_bounced = 0;

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $counts_in_sequence = 0;

                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $sql = "SELECT
                                        *
                                      FROM
                                        `sap_prospect_mailings`
                                      WHERE `outreach_account_id` = '{$outreachAccount['id']}'
                                        AND state = 'bounced'
                                        AND prospect_id != 0
                                        AND (date_format(bounced_at, '%Y-%m-%d') BETWEEN '$date_start' AND '$date_end')
                                        GROUP BY prospect_id";
                        $count_arr = Db::fetchAll(
                            $sql
                        );

                        $counts_bounced += count($count_arr);
                        ## $counts_bounced += $bounced_count_arr['counts_in_sequence'];
                    }
                }


                $response['status'] = 'success';
                $response['no_prospects_bounced'] = $counts_bounced;
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['no_prospects_bounced'] = 0;
                $response['message'] = $exc->getMessage();
            }

            echo json_encode($response);
            break;
        case 'ajax-stats-get-no-prospects-in-sequence':
            $response = [];
            $client_id = $_POST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $counts_in_sequence = 0;

                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $sql_mailed = "SELECT
                                        COUNT(*) AS counts_in_sequence
                                      FROM
                                        `sap_outreach_prospect_stage_v2`
                                      WHERE `sap_outreach_prospect_stage_v2`.`outreach_prospect_id` IN
                                        (SELECT
                                          id
                                        FROM
                                          `sap_outreach_prospect`
                                        WHERE sap_outreach_prospect.`outreach_account_id` = '{$outreachAccount['id']}')
                                        AND `sap_outreach_prospect_stage_v2`.`stage_id` = 2 ";



                        $mailed_count_arr = Db::fetch(
                            $sql_mailed
                        );

                        $counts_in_sequence += $mailed_count_arr['counts_in_sequence'];
                    }
                }


                $response['status'] = 'success';
                $response['no_prospects_in_sequence'] = $counts_in_sequence;
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['no_prospects_in_sequence'] = 0;
                $response['message'] = $exc->getMessage();
            }

            echo json_encode($response);
            break;
        case 'ajax-stats-get-no-prospects-cold-pending':
            $response = [];
            $client_id = $_POST['_client_id'];
            $date_start = Util::convertDate($_POST['_date_start'], 'm/d/Y', 'Y-m-d');
            $date_end = Util::convertDate($_POST['_date_end'], 'm/d/Y', 'Y-m-d');

            try {
                $outreachAccounts = Db::fetchAll(
                    "SELECT a.*
                       FROM `sap_client_account_outreach` a
                      WHERE a.`client_id` = :id",
                    ['id' => $client_id]
                );

                $counts_in_sequence = 0;

                if (!empty($outreachAccounts)) {
                    foreach ($outreachAccounts as $outreachAccount) {
                        $sql_mailed = "SELECT
                                        COUNT(*) AS counts_cold_pending
                                      FROM
                                        `sap_outreach_prospect_stage_v2`
                                      WHERE `sap_outreach_prospect_stage_v2`.`outreach_prospect_id` IN
                                        (SELECT
                                          id
                                        FROM
                                          `sap_outreach_prospect`
                                        WHERE sap_outreach_prospect.`outreach_account_id` = '{$outreachAccount['id']}')
                                        AND `sap_outreach_prospect_stage_v2`.`stage_id` = 1 ";

                        $mailed_count_arr = Db::fetch(
                            $sql_mailed
                        );

                        $counts_in_sequence += $mailed_count_arr['counts_cold_pending'];
                    }
                }


                $response['status'] = 'success';
                $response['no_prospects_cold_pending'] = $counts_in_sequence;
            } catch (Exception $exc) {

                $response['status'] = 'fail';
                $response['no_prospects_cold_pending'] = 0;
                $response['message'] = $exc->getMessage();
            }

            echo json_encode($response);
            break;
        case 'delete':
            $clientId = Route::uriParam('id');
            Db::query(
                'DELETE FROM `sap_client_assignment` WHERE `client_id` = :client_id',
                ['client_id' => $clientId]
            );

            Db::query(
                'DELETE FROM `sap_client` WHERE `id` = :id',
                ['id' => $clientId]
            );

            Route::setFlash('success', 'Client successfully deleted');
            header('Location: /clients');
            exit;
            break;

        case 'dne':
            $client = Db::fetch(
                'SELECT * FROM `sap_client` WHERE `id` = :id',
                ['id' => Route::uriParam('id')]
            );

            sapperView('clients-dne', ['client' => $client]);
            break;

        case 'dne-export':
            $clientName = Db::fetchColumn(
                'SELECT * FROM `sap_client`
                  WHERE `id` = :id',
                ['id' => Route::uriParam('id')],
                'name'
            );

            $filename = str_replace([',', '.', '!', '`', '"', "'"], '', $clientName) . '_dne_' . date('Ymd') . '.csv';

            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Description: File Transfer');
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename={$filename}");
            header("Expires: 0");
            header("Pragma: public");

            $fh      = fopen( 'php://output', 'w' );
            $domains = Db::fetchAll(
                'SELECT `domain` FROM `sap_client_dne`
                  WHERE `client_id` = :id',
                ['id' => Route::uriParam('id')]
            );

            foreach ($domains as $domain) {
                fwrite($fh, $domain['domain'] . "\n");
            }

            fclose($fh);
            exit;
            break;

        case 'profile-edit':
            $profileId = Route::uriParam('profile_id');
            $profile   = Db::fetch(
                'SELECT p.*, c.`name` AS `client_name`, c.`id` AS `client_id`
                   FROM `sap_client_profile` p
              LEFT JOIN `sap_client` c ON p.`client_id` = c.`id`
                  WHERE p.`id` = :profile_id',
                ['profile_id' => $profileId]
            );

            if (false == $profile) {
                sapperView(
                    'error',
                    [
                        'title'   => '404 Not Found',
                        'message' => 'Sorry, that search profile could not be found.'
                    ]
                );
            }

            $profileTitles   = [];
            foreach (Db::fetchAll(
                'SELECT * FROM `sap_client_profile_title` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            ) as $profileTitle) {
                $profileTitles[] = $profileTitle['title_id'];
            }

            $profileDepartments = [];
            foreach (Db::fetchAll(
                'SELECT * FROM `sap_client_profile_department` WHERE `client_profile_id` = :profile_id',
                ['profile_id' => $profileId]
            ) as $profileDepartment) {
                $profileDepartments[] = $profileDepartment['department_id'];
            }

            $titles       = [];
            $titlesDB     = Db::fetchAll(
                'SELECT t.*, g.name AS `group`
                   FROM `sap_group_title` t
              LEFT JOIN `sap_group` g ON t.`group_id` = g.`id`
               ORDER BY g.`sort_order` ASC, t.`sort_order` ASC'
            );

            foreach ($titlesDB as $titleDB) {
                if (!array_key_exists($titleDB['group'], $titles)) {
                    $titles[$titleDB['group']] = [];
                }
                $titles[$titleDB['group']][$titleDB['id']] = $titleDB['name'];
            }

            $departments  = Db::fetchAll('SELECT * FROM `sap_department` ORDER BY `department` ASC');

            sapperView(
                'clients-profile-edit',
                [
                    'profile'            => $profile,
                    'profileTitles'      => $profileTitles,
                    'profileDepartments' => $profileDepartments,
                    'titles'             => $titles,
                    'departments'        => $departments
                ]
            );
            break;

        case 'profile-delete':
            $clientId = Db::fetchColumn(
                'SELECT `client_id` FROM `sap_client_profile` WHERE `id` = :profile_id',
                ['profile_id' => Route::uriParam('profile_id')],
                'client_id'
            );

            Db::query(
                'DELETE FROM `sap_client_profile` WHERE `id` = :id',
                ['id' => Route::uriParam('profile_id')]
            );

            Route::setFlash('success', 'Search profile successfully deleted');

            header('Location: /clients/edit/' . $clientId);
            exit;
            break;

    }
} else {
    // List of all users stored in the database to add to the CSM drop down list
    $users = Db::fetchAll(
        "
        SELECT `id` as `value`, CONCAT(`first_name`, ' ', `last_name`) as `text`
        FROM `sap_user`
        WHERE `pod_id` IS NOT NULL
        ORDER BY `text`  ASC
        "
    );

    $companies = Db::fetchAll(
        'SELECT * FROM `sap_client_prosperworks` WHERE `name` IS NOT NULL ORDER BY `name` ASC'
    );

    $clients = Db::fetchAll(
        "SELECT c.*, c.status AS client_status,COUNT(cs.`id`) AS `suppression_domains`, hs.*, cp.`name` as pod, CONCAT(u.`first_name`, ' ', u.`last_name`) as cms
         FROM `sap_client` c
         LEFT JOIN `sap_client_dne` cs ON cs.`client_id` = c.`id`
         LEFT JOIN `sap_client_health_score` hs ON hs.`client_id` = c.`id`
         LEFT JOIN `sap_user` u ON u.`id` = c.`user_id`
         LEFT JOIN `sap_pod` cp ON u.`pod_id` = cp.`id`
         GROUP BY c.`id`
         ORDER BY c.`name` ASC"
    );

    sapperView('clients', ['clients' => $clients, 'users' => $users, 'companies' => $companies]);
}
