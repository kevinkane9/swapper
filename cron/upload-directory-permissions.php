<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

$target = __DIR__. '/../upload/'. date('Y-m-d');

if (!file_exists($target)){
    mkdir($target);
}

exec('sudo chown -R www-data: ' . $target);
