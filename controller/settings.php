<?php

use Sapper\Db;
use Sapper\Route;

// handle submissions
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    Db::query(
        'UPDATE `sap_settings` SET `settings` = :settings WHERE `id` = 1',
        ['settings' => json_encode($_POST['settings'], JSON_UNESCAPED_SLASHES)]
    );

    Route::setFlash('success', 'Settings successfully saved');
}

// list pages
$settings = Db::fetch('SELECT * FROM `sap_settings` WHERE `id` = 1');
$settings = json_decode($settings['settings'], true);

sapperView('settings', ['settings' => $settings]);