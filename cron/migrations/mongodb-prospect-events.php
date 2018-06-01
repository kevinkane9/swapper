<?php

use Sapper\Db;

require_once(__DIR__ . '/../../init.php');

set_time_limit(0);

$azure = 'mongodb://sapper-suite-test:7atmKf1vJcMGvy7e4CUV9hAWKQExjY1pZks98EpGISaAhCCp3wzwusRZ299Pahoi9nCQdTOTHdEgfNQTunhQ8w==@sapper-suite-test.documents.azure.com:10255/?ssl=true&replicaSet=globaldb';
$atlas = 'mongodb://sapper-suite-test:passw0rd123@sapperconsultingtest-shard-00-00-buad2.mongodb.net:27017,sapperconsultingtest-shard-00-01-buad2.mongodb.net:27017,sapperconsultingtest-shard-00-02-buad2.mongodb.net:27017/test?ssl=true&replicaSet=SapperConsultingTest-shard-0&authSource=admin';
$client = new MongoDB\Client($azure);

$database = $client->selectDatabase('sapper-suite-test');

$collection = $database->selectCollection('prospect-events');

$events = Db::fetchAll(
    'SELECT * FROM `sap_outreach_prospect_event`'
);

// denormalize data
foreach ($events as $i => $event) {

    if (!empty($events[$i]['metadata'])) {
        $events[$i]['metadata'] = json_decode($events[$i]['metadata'], true);
    }

    $outreachProspect = Db::fetch(
        'SELECT * FROM `sap_outreach_prospect` WHERE `id` ='. $event['outreach_prospect_id']
    );

    if ($outreachProspect) {
        // outreach account
        $outreachProspect['outreach_account_email'] = Db::fetch(
            'SELECT * FROM `sap_client_account_outreach` WHERE `id` ='. $outreachProspect['outreach_account_id']
        );

        // stages
        $outreachProspect['stages'] = Db::fetchAll(
            'SELECT *
               FROM `sap_outreach_prospect_stage` ops
          LEFT JOIN `sap_prospect_stage` ps ON ops.`stage_id` = ps.`id`
              WHERE ops.`outreach_prospect_id` ='. $outreachProspect['id']
        );

        // tags
        $outreachProspect['tags'] = Db::fetchAll(
            'SELECT *
               FROM `sap_outreach_prospect_tag` opt
          LEFT JOIN `sap_prospect_tag` pt ON opt.`tag_id` = pt.`id`
              WHERE opt.`outreach_prospect_id` ='. $outreachProspect['id']
        );

        // prospect
        $prospect = Db::fetch(
            'SELECT * FROM `sap_prospect` WHERE `id` ='. $outreachProspect['prospect_id']
        );

        if ($prospect) {
            $prospect['company']  = Db::fetch('SELECT * FROM `sap_prospect_company` WHERE `id` ='. $prospect['id']);
            $prospect['industry'] = Db::fetch('SELECT * FROM `sap_prospect_industry` WHERE `id` ='. $prospect['id']);
            $prospect['city']     = Db::fetch('SELECT * FROM `sap_prospect_city` WHERE `id` ='. $prospect['id']);
            $prospect['state']    = Db::fetch('SELECT * FROM `sap_prospect_state` WHERE `id` ='. $prospect['id']);
            $prospect['country']  = Db::fetch('SELECT * FROM `sap_prospect_country` WHERE `id` ='. $prospect['id']);
            $prospect['source']   = Db::fetch('SELECT * FROM `sap_prospect_source` WHERE `id` ='. $prospect['id']);

            $outreachProspect['prospect'] = $prospect;
        }

        $events[$i]['outreach_prospect'] = $outreachProspect;
    }

    // remove id's
    if (is_array($events[$i]) && array_key_exists('id', $events[$i])) { unset($events[$i]['id']); }
    if (is_array($events[$i]['outreach_prospect']) && array_key_exists('id', $events[$i]['outreach_prospect'])) { unset($events[$i]['outreach_prospect']['id']); }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['id']);
    }

    if (is_array($events[$i]['outreach_prospect']['stages'])) {
        foreach ($events[$i]['outreach_prospect']['stages'] as $j => $stage) {
            unset($events[$i]['outreach_prospect']['stages'][$j]['id']);
            unset($events[$i]['outreach_prospect']['stages'][$j]['outreach_prospect_id']);
            unset($events[$i]['outreach_prospect']['stages'][$j]['tag_id']);
        }
    }
    if (is_array($events[$i]['outreach_prospect']['tags'])) {
        foreach ($events[$i]['outreach_prospect']['tags'] as $j => $stage) {
            unset($events[$i]['outreach_prospect']['tags'][$j]['id']);
            unset($events[$i]['outreach_prospect']['tags'][$j]['outreach_prospect_id']);
            unset($events[$i]['outreach_prospect']['tags'][$j]['tag_id']);
        }
    }

    // remove reference id's
    if (is_array($events[$i]) && array_key_exists('outreach_prospect_id', $events[$i])) {
        unset($events[$i]['outreach_prospect_id']);
    }
    if (is_array($events[$i]) && array_key_exists('client_id', $events[$i])) {
        unset($events[$i]['client_id']);
    }
    if (is_array($events[$i]['outreach_prospect']) && array_key_exists('prospect_id', $events[$i]['outreach_prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect_id']);
    }
    if (is_array($events[$i]['outreach_prospect']) && array_key_exists('prospect_id', $events[$i]['outreach_prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect_id']);
    }
    if (is_array($events[$i]['outreach_prospect']) && array_key_exists('outreach_account_id', $events[$i]['outreach_prospect'])) {
        unset($events[$i]['outreach_prospect']['outreach_account_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('company_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['company_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('industry_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['industry_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('city_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['city_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('state_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['state_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('country_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['country_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('source_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['source_id']);
    }
    if (is_array($events[$i]['outreach_prospect']['prospect']) && array_key_exists('stage_id', $events[$i]['outreach_prospect']['prospect'])) {
        unset($events[$i]['outreach_prospect']['prospect']['stage_id']);
    }

    // flatten data
    if (is_array($events[$i]['outreach_prospect']['outreach_account_email'])) {
        $events[$i]['outreach_prospect']['outreach_account_email'] = $events[$i]['outreach_prospect']['outreach_account_email']['email'];
    }

    if (is_array($events[$i]['outreach_prospect']['stages'])) {
        foreach ($events[$i]['outreach_prospect']['stages'] as $j => $data) {
            $events[$i]['outreach_prospect']['stages'][$j] = $data['name'];
        }
    }

    if (is_array($events[$i]['outreach_prospect']['tags'])) {
        foreach ($events[$i]['outreach_prospect']['tags'] as $j => $data) {
            $events[$i]['outreach_prospect']['tags'][$j] = $data['name'];
        }
    }

    foreach (['company', 'industry', 'city', 'state', 'country', 'source'] as $key) {
        if (is_array($events[$i]['outreach_prospect']['prospect'][$key])) {
            $events[$i]['outreach_prospect']['prospect'][$key] = $events[$i]['outreach_prospect']['prospect'][$key]['name'];
        }
    }

    $result = $collection->insertOne($events[$i]);
}

//echo '<pre>', print_r($database->listCollections(), true); exit;
//$database = $client->selectDatabase('local');

//echo '<pre>', print_r($database->listCollections(), true); exit;

//$collection = $client->selectCollection('sapper-suite-test', 'prospect-events');

//echo '<pre>', print_r($collection, true); exit;