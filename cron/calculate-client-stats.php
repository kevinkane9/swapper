<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\GmailEvent;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$aggregator = new ClientStatsAggregator();

$clientStatsDir = APP_ROOT_PATH.'/upload/client-stats';
$clientStatsTodayDir = $clientStatsDir .'/'. date('Y-m-d');

if (!file_exists($clientStatsDir)) {
    mkdir($clientStatsDir);
}

if (!file_exists($clientStatsTodayDir)) {
    mkdir($clientStatsTodayDir);
}

// message stats
$rows = ClientStatsAggregator::getMessageStats();

file_put_contents($clientStatsTodayDir .'/message-stats', json_encode($rows));

foreach ($rows as $i => $row) {
    $clientId = $row['client_id'];

    if (0 == $clientId) {
        unset($rows[$i]);
        continue;
    }

    $client = Db::fetch(
        'SELECT * FROM `sap_client` WHERE `id` = :client_id',
        ['client_id' => $clientId]
    );

    if (!$client) {
        unset($rows[$i]);
        continue;
    }

    $aggregator->initializeClient($clientId);

    $key = ('outbound_message' == $row['action']) ? 'outbound_messages' : 'bounced_messages';

    $aggregator->data[$clientId][$key] = $row['count'];
}

// unique message stats
$rows = ClientStatsAggregator::getUniqueMessageStats();

file_put_contents($clientStatsTodayDir .'/message-unique-stats', json_encode($rows));

foreach ($rows as $i => $row) {
    $clientId = $row['client_id'];

    if (0 == $clientId) {
        unset($rows[$i]);
        continue;
    }

    $client = Db::fetch(
        'SELECT * FROM `sap_client` WHERE `id` = :client_id',
        ['client_id' => $clientId]
    );

    if (!$client) {
        unset($rows[$i]);
        continue;
    }

    $aggregator->initializeClient($clientId);

    $key = ('outbound_message' == $row['action']) ? 'outbound_messages_unique' : 'bounced_messages_unique';

    $aggregator->data[$clientId][$key] = $row['count'];
}

// meeting counts
foreach (array_keys($aggregator->data) as $clientId) {
    $aggregator->data[$clientId]['accepted_meetings'] = ClientStatsAggregator::getMeetingCount($clientId);
}

// calculate stats
foreach (array_keys($aggregator->data) as $clientId) {

    // MCR
    if (0 == $aggregator->data[$clientId]['accepted_meetings']
        || ($aggregator->data[$clientId]['outbound_messages_unique'] - $aggregator->data[$clientId]['bounced_messages_unique']) <= 0
    ) {
        $aggregator->data[$clientId]['mcr'] = 0;
    } else {
        $aggregator->data[$clientId]['mcr'] = number_format(
            (
                $aggregator->data[$clientId]['accepted_meetings'] /
                ($aggregator->data[$clientId]['outbound_messages_unique'] - $aggregator->data[$clientId]['bounced_messages_unique'])
            ) * 100,
            2, '.', ''
        );
    }

    // PPM
    if (0 == ($aggregator->data[$clientId]['outbound_messages_unique'] - $aggregator->data[$clientId]['bounced_messages_unique'])
        || 0 == $aggregator->data[$clientId]['accepted_meetings']
    ) {
        $aggregator->data[$clientId]['ppm'] = 0;
    } else {
        $aggregator->data[$clientId]['ppm'] = number_format(
            ($aggregator->data[$clientId]['outbound_messages_unique'] - $aggregator->data[$clientId]['bounced_messages_unique']) /
            $aggregator->data[$clientId]['accepted_meetings'],
            2, '.', ''
        );
    }
}

// insert stats
$date = date('Y-m-d');
foreach ($aggregator->data as $clientId => $data) {
    Db::insert(
        "INSERT INTO `sap_client_stats`
         (`client_id`, `accepted_meetings`, `outbound_messages`, `outbound_messages_unique`, `bounced_messages`, `bounced_messages_unique`, `mcr`, `ppm`, `date_calculated`)
         VALUES (:client_id, :accepted_meetings, :outbound_messages, :outbound_messages_unique, :bounced_messages, :bounced_messages_unique, :mcr, :ppm, :date_calculated)",
        [
            'client_id'                => $clientId,
            'accepted_meetings'        => $data['accepted_meetings'],
            'outbound_messages'        => $data['outbound_messages'],
            'outbound_messages_unique' => $data['outbound_messages_unique'],
            'bounced_messages'         => $data['bounced_messages'],
            'bounced_messages_unique'  => $data['bounced_messages_unique'],
            'mcr'                      => $data['mcr'],
            'ppm'                      => $data['ppm'],
            'date_calculated'          => $date
        ]
    );
}

class ClientStatsAggregator {

    public $data = [];

    /**
     * @param $clientId
     */
    public function initializeClient($clientId)
    {
        if (!array_key_exists($clientId, $this->data)) {
            $this->data[$clientId] = [
                'accepted_meetings'        => 0,
                'outbound_messages'        => 0,
                'outbound_messages_unique' => 0,
                'bounced_messages'         => 0,
                'bounced_messages_unique'  => 0,
                'mcr'                      => 0,
                'ppm'                      => 0
            ];
        }
    }

    public static function getMessageStats()
    {
        return Db::fetchAll(
            "SELECT COUNT(*) AS `count`, `client_id`, `action`
               FROM `sap_outreach_prospect_event`
        FORCE INDEX(`action_occurred_index`)
              WHERE `action` IN ('outbound_message', 'bounced_message')
                AND CONCAT(DATE_SUB(DATE(NOW()), INTERVAL 90 DAY), ' 00:00:00') <= `occurred_at`
           GROUP BY `client_id`, `action`"
        );
    }

    public static function getUniqueMessageStats()
    {
        return Db::fetchAll(
            "SELECT COUNT(DISTINCT(`outreach_prospect_id`)) AS `count`, `client_id`, `action`
               FROM `sap_outreach_prospect_event`
        FORCE INDEX(`action_occurred_index`)
              WHERE `action` IN ('outbound_message', 'bounced_message')
                AND CONCAT(DATE_SUB(DATE(NOW()), INTERVAL 90 DAY), ' 00:00:00') <= `occurred_at`
           GROUP BY `client_id`, `action`"
        );
    }

    public static function getMeetingCount($clientId)
    {
        $extraCriteria = " e.created_at >= CONCAT(DATE_SUB(DATE(NOW()), INTERVAL 90 DAY), ' 00:00:00') ";

        return GmailEvent::getEligibleEvents($extraCriteria, null, null, null, $clientId, true);
    }
}
