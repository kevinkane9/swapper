<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;
use Sapper\Util;
use Sapper\Api\Outreach;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

$template = Db::fetch('SELECT * FROM `sap_outreach_template` WHERE `synced` = 0 ORDER BY RAND() LIMIT 1');

if (empty($template)) {
    exit;
}

$outreachAccount = Db::fetchById('sap_client_account_outreach', $template['outreach_account_id']);

if (empty($outreachAccount) || 'disconnected' == $outreachAccount['status']) {
    exit;
}

$response = Outreach::call(
    'templates/'. $template['template_id'],
    [],
    $outreachAccount['access_token'],
    'get',
    Outreach::URL_REST_v2
);

if ('success' == $response['status']) {

    $templateId = Util::val($response, ['data', 'data', 'id']);

    if (!$templateId || $templateId !== $template['template_id']) {
        print 'Unexpected API response data';
        exit;
    }

    Db::updateRowById(
        'outreach_template',
        $template['id'],
        [
            'synced'       => 1,
            'body_html'    => Util::val($response, ['data', 'data', 'attributes', 'bodyHtml']),
            'body_text'    => Util::val($response, ['data', 'data', 'attributes', 'bodyText']),
            'last_used_at' => date('Y-m-d H:i:s', strtotime(Util::val($response, ['data', 'data', 'attributes', 'lastUsedAt']))),
            'subject'      => Util::val($response, ['data', 'data', 'attributes', 'subject'])
        ]
    );

} else {
    throw new \Exception($response['error']);
}