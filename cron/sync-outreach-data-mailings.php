<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Util;
use Sapper\Api\Outreach;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$count = Db::fetchColumn(
    'SELECT COUNT(*) AS `count` FROM `sap_outreach_prospect` WHERE `mailings_sync_status` = "syncing"',
    [], 'count'
);

if ($count >= 10) {
    echo 'Max # of syncs already in progress';
    exit;
}

$prospectId = Db::fetchColumn(
    'SELECT p.`id` FROM `sap_gmail_events` e
  LEFT JOIN `sap_client_account_gmail` g ON e.`account_id` = g.`id`
  LEFT JOIN `sap_client_account_outreach` o ON g.`client_id` = o.`client_id`
  LEFT JOIN `sap_outreach_prospect` p ON e.`prospect_id` = p.`prospect_id` AND p.`outreach_account_id` = o.`id`
      WHERE p.`id` IS NOT NULL
        AND p.`mailings_sync_status` = "ready"
   GROUP BY p.`id`
   ORDER BY p.`mailings_synced_until` ASC',
    [], 'id'
);

// since above queries is slow, let's re-pull the account
// to ensure another thread isn't already working on it
$prospect = Db::fetch(
    'SELECT * FROM `sap_outreach_prospect` WHERE `id` = :id AND `mailings_sync_status` = "ready"',
    ['id' => $prospectId]
);

if (empty($prospect)) {
    exit;
}

$outreachAccount = Db::fetchById('sap_client_account_outreach', $prospect['outreach_account_id']);

if (empty($outreachAccount) || 'disconnected' == $outreachAccount['status']) {
    exit;
}

// begin sync
Db::updateRowById(
    'outreach_prospect',
    $prospect['id'],
    ['mailings_sync_status' => 'syncing']
);

try {
    $params = [
        'filter[prospect][id]' => $prospect['outreach_id'],
        'page[limit]'          => 100,
        'sort'                 => 'updatedAt',
    ];

    if (!empty($prospect['mailings_synced_until'])) {
        $params['filter[updatedAt]'] = $prospect['mailings_synced_until'].'..inf';
    }

    $response = Outreach::call(
        'mailings',
        $params,
        $outreachAccount['access_token'],
        'get',
        Outreach::URL_REST_v2
    );

    if ('success' == $response['status']) {

        $updatedAt = null;

        foreach ($response['data']['data'] as $row) {

            $mailingId  = Util::val($row, ['id']);
            $templateId = Util::val($row, ['relationships', 'template', 'data', 'id']);

            if (!$mailingId || !$templateId) {
                continue;
            }

            $fields = [
                'outreach_prospect_id' => $prospect['id'],
                'mailing_id'           => $mailingId,
                'delivered_at'         => date('Y-m-d H:i:s', strtotime($row['attributes']['deliveredAt'])),
                'bounced'              => !empty($row['attributes']['bouncedAt']) ? 1 : 0,
                'template_id'          => $templateId
            ];

            $existing = Db::fetch(
                'SELECT *
                   FROM `sap_outreach_prospect_mailing`
                  WHERE `outreach_prospect_id` = :prospect_id
                    AND `mailing_id` = :mailing_id',
                [
                    'prospect_id' => $prospect['id'],
                    'mailing_id'  => $mailingId
                ]
            );

            if ($existing) {
                Db::updateRowById('outreach_prospect_mailing', $existing['id'], $fields);
            } else {

                Db::createRow('outreach_prospect_mailing', $fields);

                $templateFields = [
                    'outreach_account_id' => $prospect['outreach_account_id'],
                    'template_id'         => $fields['template_id']
                ];

                $template = Db::fetch(
                    'SELECT *
                       FROM `sap_outreach_template`
                      WHERE `outreach_account_id` = :outreach_account_id
                        AND `template_id` = :template_id',
                    $templateFields
                );

                if (!$template) {
                    Db::createRow('outreach_template', $templateFields);
                }
            }

            $updatedAt = Util::val($row, ['attributes', 'updatedAt']);

            if ($updatedAt) {
                Db::updateRowById(
                    'outreach_prospect',
                    $prospect['id'],
                    ['mailings_synced_until' => $updatedAt]
                );
            }
        }
    } else {
        throw new \Exception($response['error']);
    }

} catch (\Exception $e) {
    Db::updateRowById(
        'outreach_prospect',
        $prospect['id'],
        ['mailings_sync_status' => 'ready']
    );

    throw $e;
}

Db::updateRowById(
    'outreach_prospect',
    $prospect['id'],
    ['mailings_sync_status' => 'ready']
);

/*
 * it's possible that the prospect never received mailings,
 * which would leave their mailings_synced_until value null
 * indefinitely.  if that's the case, set it to $now so it
 * doesn't continue syncing from inception indefinitely
 */

if (null == $updatedAt) {
    $prospect = Db::fetchById('sap_outreach_prospect', $prospect['id']);

    if (is_array($prospect) && array_key_exists('mailings_synced_until', $prospect)
        && empty($prospect['mailings_synced_until'])
    ) {
        Db::updateRowById(
            'outreach_prospect',
            $prospect['id'],
            ['mailings_synced_until' => date('Y-m-d H:i:s')]
        );
    }
}
