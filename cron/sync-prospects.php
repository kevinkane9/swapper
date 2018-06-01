<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Api\Outreach;
use Sapper\Db;
use Sapper\Model;
use Sapper\Settings;
use Sapper\Util;

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

    $count = Db::fetch('SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status` = "syncing" AND `under_process_by` = "' . basename(__FILE__, '.php') . '"');

    if ($count['count'] >= 15) {
        echo 'Max # of syncs already in progress';
        exit;
    }

    $account = Db::fetch(
        'SELECT  *
           FROM `sap_client_account_outreach`
          WHERE `status` = "connected"
            AND (`last_pulled_at` IS NULL OR `last_pulled_at` < :one_hour_ago)
       ORDER BY `last_pulled_at` ASC',
        ['one_hour_ago' => date('Y-m-d H:i:s', time() - (7200))]
    );
}

if (empty($account)) {
    exit;
}

$accountId = $account['id'];

Db::query(
    'UPDATE `sap_client_account_outreach` SET `status` = "syncing", `under_process_by` = "' . basename(__FILE__, '.php') . '" WHERE `id` = :id',
    ['id' => $accountId]
);

// sync prospects
$page               = 1;
$prospectsRemaining = false;
$geocodes           = [];
$params             = [];
$externalIds        = [];

if (null !== $account['last_pulled_at']) {
    $lastPulledAt = strtotime($account['last_pulled_at']);
    $params['filter[metadata/updated/after]'] = date('Y-m-d', $lastPulledAt) . 'T' . date('H:i:s', $lastPulledAt) . '.000Z';
}

do {
    $params['page[number]'] = $page;

    // re-fetch account in case access token has been refreshed since last API query
    $account = Db::fetch(
        'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
        ['id' => $accountId]
    );

    $prospects = Outreach::call(
        'prospects',
        $params,
        $account['access_token'],
        'get'
    );
    
    if ('success' == $prospects['status']) {

        foreach ($prospects['data']['data'] as $prospectData) {
            
            $prospect = Outreach::call(
                'prospects/' . $prospectData['id'],
                [],
                $account['access_token'],
                'get'
            );

            if ('success' == $prospect['status']) {

                $email = Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'email']);

                if (null == $email || '' == $email) {
                    continue;
                }

                $companyId = Util::prospectAttributeId(
                    'prospect_company',
                    Util::val($prospect, ['data', 'data', 'attributes', 'company', 'name'])
                );

                $industryId = Util::prospectAttributeId(
                    'prospect_industry',
                    Util::val($prospect, ['data', 'data', 'attributes', 'company', 'industry'])
                );

                $cityId = Util::prospectAttributeId(
                    'prospect_city',
                    Util::val($prospect, ['data', 'data', 'attributes', 'address', 'city'])
                );

                $state     = Util::val($prospect, ['data', 'data', 'attributes', 'address', 'state']);
                $states    = Model::get('states');
                $stateCode = (2 == strlen($state)) ? $state : array_search(trim($state), $states);

                $stateId = Util::prospectAttributeId('prospect_state', $stateCode);

                $countryId = Util::prospectAttributeId(
                    'prospect_country',
                    Util::val($prospect, ['data', 'data', 'attributes', 'address', 'country'])
                );

                $sourceId = Util::prospectAttributeId(
                    'prospect_source',
                    Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'source'])
                );

                $stageIds = [];
                $stages   = Util::val($prospect, ['data', 'data', 'attributes', 'stage']);

                if (is_string($stages)) {
                    $stages = [$stages];
                }
                if (is_array($stages)) {
                    foreach ($stages as $stage) {
                        $stageId = Util::prospectAttributeId('prospect_stage', $stage);
                        if (!is_null($stageId)) {
                            $stageIds[] = $stageId;
                        }
                    }
                }

                $tagIds = [];
                $tags   = Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'tags']);

                if (is_string($tags)) {
                    $tags = [$tags];
                }

                if (is_array($tags)) {
                    foreach ($tags as $tag) {
                        $tagId = Util::prospectAttributeId('prospect_tag', $tag);
                        if (!is_null($tagId)) {
                            $tagIds[] = $tagId;
                        }
                    }
                }

                $prospectId = Db::fetchColumn(
                    'SELECT `id` FROM `sap_prospect` WHERE `email` = :email',
                    ['email' => $email],
                    'id'
                );

                $existingProspect = false;
                if (is_int($prospectId) && $prospectId > 0) {

                    Util::addLog("Prospect is in database (outreach account id: {$account['id']} prospect id: {$prospectId})");

                    $existingProspect = true;

                    Db::query(
                        'UPDATE `sap_prospect`
                                SET `first_name` = :first_name, `last_name` = :last_name, `title` = :title,
                                `company_id` = :company_id, `company_revenue` = :company_revenue, `industry_id` = :industry_id,
                                `company_employees` = :company_employees, `address` = :address, `address2` = :address2,
                                `city_id` = :city_id, `state_id` = :state_id, `zip` = :zip, `country_id` = :country_id,
                                `phone_work` = :phone_work, `phone_personal` = :phone_personal, `source_id` = :source_id,
                                `opted_out` = :opted_out
                              WHERE `id` = :id',
                        [
                            'first_name'        => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'first']),
                            'last_name'         => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'last']),
                            'title'             => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'title']),
                            'company_id'        => $companyId,
                            'company_revenue'   => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'custom', 1]),
                            'industry_id'       => $industryId,
                            'company_employees' => Util::val($prospect, ['data', 'data', 'attributes', 'company', 'size']),
                            'address'           => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 0]),
                            'address2'          => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 1]),
                            'city_id'           => $cityId,
                            'state_id'          => $stateId,
                            'zip'               => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'zip']),
                            'country_id'        => $countryId,
                            'phone_work'        => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'work']),
                            'phone_personal'    => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'personal']),
                            'source_id'         => $sourceId,
                            'opted_out'         => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'opted_out']) ?: 0,
                            'id'                => $prospectId
                        ]
                    );
                } else {
                    Util::addLog("Prospect is not in database (email: {$email})");

                    try {
                        $prospectId = Db::insert(
                            'INSERT INTO `sap_prospect`
                      (`email`, `first_name`, `last_name`, `title`, `company_id`, `company_revenue`, `industry_id`,
                       `company_employees`, `address`, `address2`, `city_id`, `state_id`, `zip`, `country_id`, `phone_work`,
                       `phone_personal`, `source_id`, `opted_out`)
                                 VALUES
                                  (:email, :first_name, :last_name, :title, :company_id, :company_revenue, :industry_id,
                                   :company_employees, :address, :address2, :city_id, :state_id, :zip, :country_id, :phone_work,
                                   :phone_personal, :source_id, :opted_out)',
                            [
                                'email' => $email,
                                'first_name' => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'first']),
                                'last_name' => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'last']),
                                'title' => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'title']),
                                'company_id' => $companyId,
                                'company_revenue' => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'custom', 1]),
                                'industry_id' => $industryId,
                                'company_employees' => Util::val($prospect, ['data', 'data', 'attributes', 'company', 'size']),
                                'address' => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 0]),
                                'address2' => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 1]),
                                'city_id' => $cityId,
                                'state_id' => $stateId,
                                'zip' => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'zip']),
                                'country_id' => $countryId,
                                'phone_work' => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'work']),
                                'phone_personal' => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'personal']),
                                'source_id' => $sourceId,
                                'opted_out' => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'opted_out']) ?: 0,
                            ]
                        );
                    } catch (Exception $e) {
                        if (false !== strpos($e->getMessage(), '1062 Duplicate')) {

                            Util::addLog("Failed to insert prospect due to duplicate email {$email}");

                            $prospectId = Db::fetchColumn(
                                'SELECT `id` FROM `sap_prospect` WHERE `email` = :email',
                                ['email' => $email],
                                'id'
                            );

                            Util::addLog("Additional lookup for prospect produced prospect_id: {$prospectId}");

                            Db::query(
                                'UPDATE `sap_prospect`
                                    SET `first_name` = :first_name, `last_name` = :last_name, `title` = :title,
                                    `company_id` = :company_id, `company_revenue` = :company_revenue, `industry_id` = :industry_id,
                                    `company_employees` = :company_employees, `address` = :address, `address2` = :address2,
                                    `city_id` = :city_id, `state_id` = :state_id, `zip` = :zip, `country_id` = :country_id,
                                    `phone_work` = :phone_work, `phone_personal` = :phone_personal, `source_id` = :source_id,
                                    `opted_out` = :opted_out
                                  WHERE `id` = :id',
                                [
                                    'first_name'        => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'first']),
                                    'last_name'         => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'name', 'last']),
                                    'title'             => Util::val($prospect, ['data', 'data', 'attributes', 'personal', 'title']),
                                    'company_id'        => $companyId,
                                    'company_revenue'   => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'custom', 1]),
                                    'industry_id'       => $industryId,
                                    'company_employees' => Util::val($prospect, ['data', 'data', 'attributes', 'company', 'size']),
                                    'address'           => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 0]),
                                    'address2'          => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'street', 1]),
                                    'city_id'           => $cityId,
                                    'state_id'          => $stateId,
                                    'zip'               => Util::val($prospect, ['data', 'data', 'attributes', 'address', 'zip']),
                                    'country_id'        => $countryId,
                                    'phone_work'        => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'work']),
                                    'phone_personal'    => Util::val($prospect, ['data', 'data', 'attributes', 'contact', 'phone', 'personal']),
                                    'source_id'         => $sourceId,
                                    'opted_out'         => Util::val($prospect, ['data', 'data', 'attributes', 'metadata', 'opted_out']) ?: 0,
                                    'id'                => $prospectId
                                ]
                            );
                        } else {
                            throwException($e, $account);
                        }
                    }
                }

                $city  = Util::val($prospect, ['data', 'data', 'attributes', 'address', 'city']);
                $state = Util::val($prospect, ['data', 'data', 'attributes', 'address', 'state']);

                if (!empty($city) && !empty($state) && false == $existingProspect) {
                    $geocodes[] = ['prospect_id' => $prospectId, 'city' => $city, 'state' => $state];
                }
                if (100 == count($geocodes)&&  1 == Settings::get('geo-encoding')) {
                    processGeocode($geocodes);
                    $geocodes = [];
                }

                $outreachProspectId = Db::fetchColumn(
                    'SELECT `id` FROM `sap_outreach_prospect` WHERE `outreach_account_id` = :outreach_account_id AND `prospect_id` = :prospect_id',
                    ['outreach_account_id' => $account['id'], 'prospect_id' => $prospectId],
                    'id'
                );

                $externalId = Util::val($prospect, ['data', 'data', 'id']);

                if (false == $outreachProspectId) {
                    try {
                        $outreachProspectId = Db::insert(
                            'INSERT INTO `sap_outreach_prospect`
                          (`outreach_account_id`, `prospect_id`, `outreach_id`)
                         VALUES
                          (:outreach_account_id, :prospect_id, :outreach_id)',
                            [
                                'outreach_account_id' => $account['id'],
                                'prospect_id'         => $prospectId,
                                'outreach_id'         => $externalId
                            ]
                        );
                    } catch (Exception $e) {

                        Util::addLog(
                            'Duplicate outreach prospect with details: ' . json_encode([
                                'pid' => getmypid(),
                                '$outreachProspectId (type)' => gettype($outreachProspectId),
                                '$outreachProspectId (val)'  => $outreachProspectId,
                                'outreach_account_id'        => $account['id'],
                                'prospect_id'                => $prospectId,
                                'outreach_id'                => $externalId
                            ])
                        );

                        throwException($e, $account);
                    }
                }

                $externalIds[$outreachProspectId] = $externalId;

                Db::query(
                    'DELETE FROM `sap_outreach_prospect_tag` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                    ['outreach_prospect_id' => $outreachProspectId]
                );

                foreach ($tagIds as $tagId) {
                    Db::insert(
                        'INSERT INTO `sap_outreach_prospect_tag`
                          (`outreach_prospect_id`, `tag_id`)
                         VALUES
                          (:outreach_prospect_id, :tag_id)',
                        [
                            'outreach_prospect_id' => $outreachProspectId,
                            'tag_id'               => $tagId
                        ]
                    );
                }

                Db::query(
                    'DELETE FROM `sap_outreach_prospect_stage` WHERE `outreach_prospect_id` = :outreach_prospect_id',
                    ['outreach_prospect_id' => $outreachProspectId]
                );

                foreach ($stageIds as $stageId) {
                    Db::insert(
                        'INSERT INTO `sap_outreach_prospect_stage`
                          (`outreach_prospect_id`, `stage_id`)
                         VALUES
                          (:outreach_prospect_id, :stage_id)',
                        [
                            'outreach_prospect_id' => $outreachProspectId,
                            'stage_id'             => $stageId
                        ]
                    );
                }
            }

            usleep(100000);
        }

        $prospectsReceived  = (50*($page-1)) + Util::val($prospects, ['data', 'meta', 'page', 'entries']) ?: 0;
        $totalProspects     = Util::val($prospects, ['data', 'meta', 'results', 'total']) ?: 0;
        $prospectsRemaining = ($prospectsReceived < $totalProspects) ? true : false;
        $page++;
    }
} while ($prospectsRemaining);

if (count($geocodes) > 0 &&  1 == Settings::get('geo-encoding')) {
    processGeocode($geocodes);
}

foreach ($externalIds as $outreachProspectId => $externalId) {
    // activities
    $page            = 1;
    $eventsRemaining = false;
    $params          = ['filter[prospect/id]' => $externalId];

    do {
        $params['page[number]'] = $page;

        // re-fetch account in case access token has been refreshed since last API query
        $account = Db::fetch(
            'SELECT * FROM `sap_client_account_outreach` WHERE `id` = :id',
            ['id' => $accountId]
        );

        $events = Outreach::call(
            'activities',
            $params,
            $account['access_token'],
            'get'
        );

        if ('success' == $events['status']) {

            foreach ($events['data']['data'] as $event) {
                $timestamp  = Util::val($event, ['attributes', 'metadata', 'timestamp']);
                $occurredAt = empty($timestamp) ? null : date('Y-m-d H:i:s', strtotime($timestamp));
                $action     = Util::val($event, ['attributes', 'action']);

                $eventDb = Db::fetch(
                        'SELECT * FROM `sap_outreach_prospect_event`
                                 WHERE `outreach_prospect_id` = :outreach_prospect_id
                                   AND `event_id` = :event_id',
                        [
                            'outreach_prospect_id' => $outreachProspectId,
                            'event_id'             => $event['id']
                        ]
                    );

                if (false == $eventDb) {

                    // get template id
                    $templateId = null;

                    if (in_array($action, ['message_opened', 'bounced_message', 'inbound_message', 'outbound_message'])) {
                        $mailingId = Util::val($event, ['attributes', 'metadata', 'mailing', 'id']);

                        if (!is_null($mailingId)) {
                            $mailing = Outreach::call(
                                'mailings/' . $mailingId,
                                [],
                                $account['access_token'],
                                'get'
                            );


                            if (is_array($mailing)) {
                                $templateId = Util::val($mailing, ['data', 'data', 'attributes', 'source', 'sequence', 'template', 'id']);
                            }
                        }
                    } else {
                        $mailingId = null;
                    }

                    try{
                        Db::insert(
                            'INSERT INTO `sap_outreach_prospect_event`
                          (`outreach_prospect_id`, `client_id`, `event_id`, `template_id`, `mailing_id`, `action`, `metadata`, `occurred_at`)
                          VALUES (:outreach_prospect_id, :client_id, :event_id, :template_id, :mailing_id, :action, :metadata, :occurred_at)',
                            [
                                'outreach_prospect_id' => $outreachProspectId,
                                'client_id'            => $account['client_id'],
                                'event_id'             => $event['id'],
                                'template_id'          => $templateId,
                                'mailing_id'           => $mailingId,
                                'action'               => $action,
                                'metadata'             => json_encode(Util::val($event, ['attributes', 'metadata']), JSON_UNESCAPED_SLASHES),
                                'occurred_at'          => $occurredAt
                            ]
                        );
                    } catch (Exception $e) {
                        if (false !== strpos($e->getMessage(), '1062 Duplicate')) {
                            Util::addLog("Couldn't insert duplicate event id (OutreachProspectId: {$outreachProspectId} EventId: {$event['id']})");
                        } else {
                            throwException($e, $account);
                        }
                    }
                    
                    // update prospect level data
                    if ('outbound_message' == $action && !is_null($occurredAt)) {
                        Db::query(
                            'UPDATE `sap_prospect`, `sap_outreach_prospect`
                            SET `sap_prospect`.`last_emailed_at` = :last_emailed_at
                          WHERE `sap_outreach_prospect`.`id` = :outreach_prospect_id
                            AND `sap_prospect`.`id` = `sap_outreach_prospect`.`prospect_id`
                            AND (`sap_prospect`.`last_emailed_at` < :last_emailed_at2 OR `sap_prospect`.`last_emailed_at` IS NULL)',
                            [
                                'outreach_prospect_id' => $outreachProspectId,
                                'last_emailed_at'      => $occurredAt,
                                'last_emailed_at2'     => $occurredAt
                            ]
                        );
                    } elseif ('bounced_message' == $action) {
                        Db::query(
                            'UPDATE `sap_prospect`, `sap_outreach_prospect`
                            SET `sap_prospect`.`bounced` = 1
                          WHERE `sap_outreach_prospect`.`id` = :outreach_prospect_id
                            AND `sap_prospect`.`id` = `sap_outreach_prospect`.`prospect_id`',
                            [
                                'outreach_prospect_id' => $outreachProspectId
                            ]
                        );
                    }
                }
            }
            $eventsReceived  = (50*($page-1)) + Util::val($events, ['data', 'meta', 'page', 'entries']) ?: 0;
            $totalEvents     = Util::val($events, ['data', 'meta', 'results', 'total']) ?: 0;
            $eventsRemaining = ($eventsReceived < $totalEvents) ? true : false;
            $page++;
        }

    } while ($eventsRemaining);
}

Db::query(
    'UPDATE `sap_client_account_outreach` SET `under_process_by` = "", `status` = "connected", `last_pulled_at` = NOW() WHERE `id` = :id',
    ['id' => $account['id']]
);

function processGeocode($geocodes) {
    $geocodes = Sapper\Api\Geocode::convert($geocodes);

    foreach ($geocodes as $geocode) {
        if (true == $geocode['geolocated']) {
            Db::query(
                'UPDATE `sap_prospect` SET `lat` = :lat, `lng` = :lng WHERE `id` = :id',
                ['lat' => $geocode['lat'], 'lng' => $geocode['lng'], 'id' => $geocode['prospect_id']]
            );
        }
    }
}

function throwException($exception, $account) {
    Db::query(
        'UPDATE `sap_client_account_outreach` SET `status` = "connected" WHERE `id` = :id',
        ['id' => $account['id']]
    );
    
    throw $exception;
}
