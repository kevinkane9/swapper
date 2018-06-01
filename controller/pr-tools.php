<?php

use Sapper\Route;

if (IS_PR_BUILD) {

    switch(Route::uriParam('action')) {

        case 'send-survey-invitations':
            exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/send-surveys.php > /dev/null 2>&1 &');
            Route::setFlash('success', 'Successfully triggered sending survey invitations');
            break;

        case 'process-job-queue':
            exec($GLOBALS['sapper-env']['PATH_TO_PHP'] . 'php ' . APP_ROOT_PATH . '/cron/process-request.php > /dev/null 2>&1 &');
            Route::setFlash('success', 'Successfully triggered processing the background job queue');
            break;
    }

    sapperView('pr-tools');
} else {
    throw new \Exception('Not available in this environment');
}