<?php

use Sapper\Route,
    Sapper\Util,
    Sapper\Db;

if ($action = Route::uriParam('action')) {
    switch ($action) {
        case 'sidebar':
            Util::collapseSidebar($_POST['state']);
            jsonSuccess();
            break;
    }
}

$stats = Db::fetch('SELECT * FROM `sap_dashboard_stat` WHERE `id` = 1');

$stats['accounts_syncing'] = Db::fetchColumn(
    'SELECT COUNT(*) AS `count` FROM `sap_client_account_outreach` WHERE `status` = "syncing"',
    [],
    'count'
);

$stats['ai-last-trained'] = Sapper\Settings::get('ai-last-trained', 'internal');

sapperView(
    'home',
    [
        'stats' => $stats
    ]
);