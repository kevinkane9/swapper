<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

$now = time();

// cleanup app logs
$dir = __DIR__ .'/../var/logs/'; // Directory path
$log_files = array_diff( scandir($dir, 1), array(".", "..") ); // Getting the list of files exist in the directory except . and ..

chmod($dir,0775);

foreach( $log_files as $file )  {
	if ( $file != '' ) {
		if (file_exists($dir.$file)) {
			if ($now - filemtime($dir.$file) >= 60 * 60 * 24 * 10) { // 10 days
				unlink($dir.$file);
			}
		}
	}
}

// cleanup Outreach API logs
chdir(__DIR__. '/../api/outreach_log');

$directories = glob("20*", GLOB_ONLYDIR);

foreach ($directories as $directory) {

	// if directory is > 3 days old, remove it
	if (($now - strtotime($directory)) > (86400*3)) {
		delTree(__DIR__. '/../api/outreach_log/'. $directory);
	}
}

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
