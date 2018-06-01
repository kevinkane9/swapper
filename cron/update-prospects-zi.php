<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

ini_set('memory_limit', '768M');

use Sapper\Db;
use Sapper\Util;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

if (array_key_exists(1, $argv)) {
    $accountId = $argv[1];
}

try {
    $csv_file = APP_ROOT_PATH . '/cron/zoominfo-data1.csv';

    $zi_prospects = array_map('str_getcsv', file($csv_file));

    $i=0;
    $uc=0;
    foreach ($zi_prospects as $zi_prospect) {
        $zoominfo_id = $zi_prospect[3];
        $zoominfo_company_id = $zi_prospect[4];
        
        if ($i > 0 ) {
            $prospect = Db::fetch(
                'SELECT * FROM `sap_prospect` WHERE `email` = :email',
                ['email' => trim($zi_prospect[1])],
                'id'
            );
            
            if (!empty($prospect)) {
                $uc++;
                
                Db::query(
                    'UPDATE `sap_prospect`
                            SET `zoominfo_id` = :zoominfo_id,`zoominfo_company_id` = :zoominfo_company_id
                          WHERE `id` = :id',
                    [
                        'zoominfo_id'        => $zoominfo_id,
                        'zoominfo_company_id'        => $zoominfo_company_id,
                        'id'                => $prospect['id']
                    ]
                );      
                
                echo "Prospect Id: {$prospect['id']} Email: {$zi_prospect[1]} updated.\n\n";
                Util::addLog("Zoominfo IDs Update Process: Prospect Id: {$prospect['id']} Email: {$zi_prospect[1]} updated.");
            }
        }
        
        $i++;
    }
    
    echo "Total {$uc} Prospects updated.<br>";
    Util::addLog("Total {$uc} Prospects updated.");
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
