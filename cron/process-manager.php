<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

chdir(__DIR__. '/../upload/');

$notes = glob(".kill-process-*");

foreach($notes as $note) {
    // Get the process Id
    $pid = intval(substr($note, strrpos($note, '-') + 1));

    // Kill the process referenced in the note
    exec("kill -9 $pid");

    // Delete the note file so the script won't try to kill process over and over again
    unlink($note);
}
