<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

use Sapper\Db;

require_once(__DIR__ . '/../init.php');

set_time_limit(0);

// build titles index
$titles = [];

$titlesDb = Db::fetchAll('SELECT * FROM `sap_group_title` ORDER BY `group_id` ASC, `sort_order` ASC');

foreach ($titlesDb as $titleDb) {
    $titleData = [
        'id'         => $titleDb['id'],
        'title'      => $titleDb['name'],
        'variations' => [],
        'negative'   => []
    ];

    // variations
    $variations = Db::fetchAll(
        'SELECT * FROM `sap_group_title_variation` WHERE `group_title_id` = :group_title_id',
        ['group_title_id' => $titleDb['id']]
    );

    foreach ($variations as $variation) {
        $titleData['variations'][] = $variation['name'];
    }

    // negatives
    $negatives = Db::fetchAll(
        'SELECT * FROM `sap_group_title_negative` WHERE `group_title_id` = :group_title_id',
        ['group_title_id' => $titleDb['id']]
    );

    foreach ($negatives as $negative) {
        $titleData['negative'][] = $negative['keyword'];
    }

    $titles[] = $titleData;
}

// get converted prospects without matched titles
$prospects = Db::fetchAll(
    'SELECT p.`id`, p.`title`
       FROM `sap_prospect` p
      WHERE p.`id` IN 
    (SELECT DISTINCT `prospect_id`
       FROM `sap_gmail_events` e
      WHERE e.prospect_id IS NOT null)
        AND p.`title` IS NOT NULL
        AND p.`group_title_id` IS NULL'
);

// find highest level title that matches
foreach ($prospects as $prospect) {

    foreach ($titles as $title) {

        $match = false;

        // test title
        if (false !== strpos($prospect['title'], $title['title'])) {
            $match = true;
        }

        // test variations
        if (!$match) {
            foreach ($title['variations'] as $variation) {
                if (false !== strpos($prospect['title'], $variation)) {
                    $match = true;
                    break;
                }
            }
        }
        
        // test negatives
        if ($match) {
            foreach ($title['negative'] as $negative) {
                if (false !== strpos($prospect['title'], $negative)) {
                    $match = false;
                    break;
                }
            }
        }
        
        if ($match) {
            Db::updateRowById(
                'prospect',
                $prospect['id'],
                [
                    'group_title_id' => $title['id']
                ]
            );
        }
    }
}




