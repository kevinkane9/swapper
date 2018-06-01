<?php

$GLOBALS['pid'] = getmypid();

// global exception handler
require_once(__DIR__ . '/exception-handler.php');

// env vars
if (!file_exists(__DIR__ . '/conf/env.php')) {
    throw new Exception ('Environment configuration missing');
}

$GLOBALS['sapper-env'] = require_once(__DIR__. '/conf/env.php');

// required env vars
foreach ([
    'DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME', 'APP_ROOT_URL', 'PATH_TO_PHP',
    'GOOGLE_JSON', 'GOOGLE_APP', 'ASSETS_VERSION', 'DEBUG', 'ENV_NAME',
    'PROSPERWORKS_EMAIL', 'PROSPERWORKS_ACCESS_TOKEN'
] as $envVar
) {
    if (!array_key_exists($envVar, $GLOBALS['sapper-env'])) {
        throw new \Exception('Missing env.php variable: '. $envVar);
    }
}

if (array_key_exists('DEBUG', $GLOBALS['sapper-env']) && true == $GLOBALS['sapper-env']['DEBUG']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR);
}

// constants
define('APP_ROOT_PATH', __DIR__);
define('APP_ROOT_URL', $GLOBALS['sapper-env']['APP_ROOT_URL']);
define('IS_PR_BUILD', 0 === strpos($GLOBALS['sapper-env']['APP_ROOT_URL'], 'https://pr'));
define('GOOGLE_JSON', $GLOBALS['sapper-env']['GOOGLE_JSON']);
define('GOOGLE_APP', $GLOBALS['sapper-env']['GOOGLE_APP']);

define('ZI_MAXRECORDS', 300);

// vendors
require_once('vendor/autoload.php');

// classes
require_once('class/util.php');
require_once('class/db.php');
require_once('class/model.php');
require_once('class/settings.php');
require_once('class/auth.php');
require_once('class/route.php');
require_once('class/prospect-list.php');
require_once('class/prospects-prepare.php');
require_once('class/mail.php');
require_once('class/gmail-event.php');
require_once('class/cosmosdb.php');

// entity
require_once('entity/user.php');

// api wrappers
require_once('api/geocode.php');
require_once('api/outreach.php');
require_once('api/outreach-sync.php');
require_once('api/list-certified/vendor/autoload.php');
require_once('api/list-certified/Operations.php');
require_once('api/ProsperworksProvider.php');
//require_once('api/CosmosDbProvider.php');
