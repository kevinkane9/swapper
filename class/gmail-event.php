<?php

namespace Sapper;

use Google_Client;
use Google_Service_Calendar;

class GmailEvent
{
    public static function getGoogleClient($gmailAccountId)
    {
        $accessToken = DB::fetchColumn(
            'SELECT access_token FROM sap_client_account_gmail WHERE `id` = :id',
            ['id' => $gmailAccountId],
            'access_token'
        );

        $client = new Google_Client();
        $client->setApplicationName(GOOGLE_APP);
        $client->setAuthConfig(APP_ROOT_PATH . '/api/' . GOOGLE_JSON);
        $client->setAccessToken(json_decode($accessToken, true));

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            Db::query(
                'UPDATE `sap_client_account_gmail` SET `access_token` = :access_token WHERE `id` = :id',
                [
                    'access_token' => json_encode($client->getAccessToken(), JSON_UNESCAPED_SLASHES),
                    'id'           => $gmailAccountId
                ]
            );
        }

        return $client;
    }

    public static function captureGmailCalendarColorData($gmailAccountId)
    {
        $client = self::getGoogleClient($gmailAccountId);

        $calendar = new Google_Service_Calendar($client);

        $account = Db::fetch(
            'SELECT email, default_color_id FROM sap_client_account_gmail WHERE `id` = :id',
            ['id' => $gmailAccountId]
        );

        $calendarList = $calendar->calendarList->listCalendarList();

        $calendarItems = $calendarList->getItems();

        foreach ($calendarItems as $calendarItem) {
            if ($calendarItem->getId() == $account['email']) {
                $defaultColorKey = $calendarItem->getColorId();
            }
        }

        if (!isset($defaultColorKey)) {
            $defaultColorKey = $calendarItems[0]->getColorId();
        }

        $colors = $calendar->colors->get();

        $data = [];

        foreach ($colors->getCalendar() as $key => $color) {
            $data[] = [
                'gmail_account_id' => $gmailAccountId,
                'color_key'        => $key,
                'type'             => 'calendar',
                'background_color' => $color->getBackground(),
                'foreground_color' => $color->getForeground(),
            ];
        }

        foreach ($colors->getEvent() as $key => $color) {
            $data[] = [
                'gmail_account_id' => $gmailAccountId,
                'color_key'        => $key,
                'type'             => 'event',
                'background_color' => $color->getBackground(),
                'foreground_color' => $color->getForeground(),
            ];
        }

        $defaultColorId = '';
        foreach ($data as $row) {
            $colorId = Db::fetchColumn(
                'SELECT id from `sap_gmail_event_colors` where `gmail_account_id` = :gmail_account_id AND `color_key` = :color_key
                 AND `type` = :type',
                [
                    'gmail_account_id' => $row ['gmail_account_id'],
                    'color_key'        => $row['color_key'],
                    'type'             => $row['type']
                ],
                'id'
            );

            if ($colorId) {
                Db::updateRowById('gmail_event_colors', $colorId, $row);
            } else {
                $colorId = DB::createRow('gmail_event_colors', $row);
            }

            if ($row['color_key'] == $defaultColorKey && $row['type'] == 'calendar') {
                $defaultColorId = $colorId;
            }
        }

        if (!empty($defaultColorId) && $defaultColorId != $account['default_color_id']) {
            Db::updateRowById('client_account_gmail', $gmailAccountId, ['default_color_id' => $defaultColorId]);
        }
    }

    public static function getEligibleEvents(
        $extraCriteria = null,
        $extraJoin = null,
        $orderBy = null,
        $gmailAccountId = null,
        $clientId = null,
        $getCount = false,
        $getOne = false,
        $eventId = null
    )
    {
        $colors = implode(',', array_map([Db::dbh(), 'quote'], GmailEvent::getEligibleColors()));

        $query = '
            SELECT '.($getCount ? 'COUNT(*) AS `count`' : '*').' FROM `sap_gmail_events` e
            JOIN `sap_gmail_event_colors` c ON e.`event_color_id` = c.`id`
            JOIN `sap_client_account_gmail` a ON a.`id` = e.`account_id`'
            . ($extraJoin ?: '') .
            'WHERE e.`status` != "cancelled" AND c.`background_color` IN ('. $colors .')
        ';

        $parameters = [];

        if (!empty($gmailAccountId)) {
            $query .= ' AND e.`account_id` = :account_id ';
            $parameters['account_id'] = $gmailAccountId;
        }

        if (!empty($clientId)) {
            $query .= ' AND a.`client_id` = :client_id ';
            $parameters['client_id'] = $clientId;
        }

        if (!empty($eventId)) {
            $query .= ' AND e.`id` = :event_id ';
            $parameters['event_id'] = $eventId;
        }

        if (!empty($extraCriteria)) {
            $query .= " AND ".$extraCriteria;
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY ".$orderBy;
        }

        if ($getCount) {
            return Db::fetchColumn($query, $parameters,'count');
        } elseif ($getOne) {
            return Db::fetch($query, $parameters);
        } else {
            return Db::fetchAll($query, $parameters);
        }
    }

    public static function getEligibleColors()
    {
        return [
            '#ff887c', // Flamingo
            '#d06b64', // Flamingo
            '#7ae7bf'  // Sage
        ];
    }

    public static function hasValidRecipient($event, $surveyEmails)
    {
        $prospectId = null;

        $prsEmail = '';
        $organizerDomain = Util::getDomainFromEmail($event->getOrganizer()->email);

        $surveyDomains = [];
        foreach (explode(',', $surveyEmails) as $surveyEmail) {
            $surveyDomains[] = Util::getDomainFromEmail($surveyEmail);
        }

        foreach($event->getAttendees() as $attendee) {
            $attendeeDomain = Util::getDomainFromEmail($attendee->email);

            if ($attendeeDomain !== $organizerDomain && !in_array($attendeeDomain, $surveyDomains)) {
                $prsEmail = $attendee->email;
                break;
            }
        }

        if (!empty($prsEmail)) {
            $prospect = Db::fetch(
                'SELECT * FROM `sap_prospect` WHERE `email` = :email',
                ['email' => $prsEmail]
            );

            if (is_array($prospect) && array_key_exists('id', $prospect)) {
                $prospectId = $prospect['id'];
            }
        }

        return [
            'valid_recipient' => !empty($prsEmail),
            'prospect_id'     => $prospectId,
        ];
    }


}
