<?php

use Sapper\Db;
use Sapper\Route;

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    switch (Route::uriParam('method')) {
        case 'sort':
            for ($i = 1; $i <= count($_POST['sortOrder']); $i++) {
                switch ($_POST['entity']) {
                    case 'group':
                        $table = 'sap_group';
                        break;

                    case 'title':
                        $table = 'sap_group_title';
                        break;
                }

                Db::query(
                    "UPDATE $table SET `sort_order` = :sort_order WHERE `id` = :id",
                    ['sort_order' => $i, 'id' => $_POST['sortOrder'][$i-1]]
                );
            }
            break;

        case 'get-titles':
            $titles = Db::fetchAll(
                'SELECT * FROM `sap_group_title` WHERE `group_id` = :group_id ORDER BY `sort_order` ASC',
                ['group_id' => $_POST['id']]
            );

            jsonResponse($titles);
            break;

        case 'get-variations':
            $variations = Db::fetchAll(
                'SELECT * FROM `sap_group_title_variation` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $_POST['id']]
            );

            jsonResponse($variations);
            break;

        case 'get-negative-keywords':
            $negatives = Db::fetchAll(
                'SELECT * FROM `sap_group_title_negative` WHERE `group_title_id` = :group_title_id',
                ['group_title_id' => $_POST['id']]
            );

            jsonResponse($negatives);
            break;

        case 'delete':
            switch ($_POST['entity']) {
                case 'group':
                    $table = 'sap_group';
                    break;

                case 'title':
                    $table = 'sap_group_title';
                    break;

                case 'variation':
                    $table = 'sap_group_title_variation';
                    break;

                case 'negative':
                    $table = 'sap_group_title_negative';
                    break;
            }
            Db::query(
                "DELETE FROM $table WHERE `id` = :id",
                ['id' => $_POST['id']]
            );
            break;

        case 'add':
            switch ($_POST['entity']) {
                case 'group':
                    $sortOrder = Db::fetchColumn(
                        'SELECT (MAX(`sort_order`) + 1) AS `sort_order` FROM `sap_group`',
                        [],
                        'sort_order'
                    );

                    $id = Db::insert(
                        'INSERT INTO `sap_group` (`name`, `sort_order`) VALUES (:name, :sort_order)',
                        [
                            'name'       => $_POST['name'],
                            'sort_order' => $sortOrder ?: 1
                        ]
                    );

                    jsonResponse(['id' => $id]);
                    break;

                case 'title':
                    $sortOrder = Db::fetchColumn(
                        'SELECT (MAX(`sort_order`) + 1) AS `sort_order` FROM `sap_group_title`',
                        [],
                        'sort_order'
                    );

                    $id = Db::insert(
                        'INSERT INTO `sap_group_title`
                                    (`group_id`, `name`, `sort_order`)
                             VALUES (:group_id, :name, :sort_order)',
                        [
                            'group_id'   => $_POST['groupId'],
                            'name'       => $_POST['name'],
                            'sort_order' => $sortOrder ?: 1
                        ]
                    );

                    jsonResponse(['id' => $id]);
                    break;

                case 'variation':
                    $id = Db::insert(
                        'INSERT INTO `sap_group_title_variation`
                                    (`group_title_id`, `name`)
                             VALUES (:group_title_id, :name)',
                        [
                            'group_title_id' => $_POST['titleId'],
                            'name'           => $_POST['name']
                        ]
                    );

                    jsonResponse(['id' => $id]);
                    break;

                case 'negative':
                    $id = Db::insert(
                        'INSERT INTO `sap_group_title_negative`
                                    (`group_title_id`, `keyword`)
                             VALUES (:group_title_id, :keyword)',
                        [
                            'group_title_id' => $_POST['titleId'],
                            'keyword'        => $_POST['keyword']
                        ]
                    );

                    jsonResponse(['id' => $id]);
                    break;
            }
            break;

        case 'save':
            foreach ($_POST['groups'] as $groupId => $group) {
                if ('' == $group) {
                    Db::query(
                        'DELETE FROM `sap_group` WHERE `id` = :id LIMIT 1',
                        ['id' => $groupId]
                    );
                } else {
                    Db::query(
                        'UPDATE `sap_group` SET `name` = :name WHERE `id` = :id LIMIT 1',
                        ['name' => $group, 'id' => $groupId]
                    );

                    if (isset($_POST['titles'][$groupId])) {
                        foreach ($_POST['titles'][$groupId] as $titleId => $title) {
                            if ('' == $title) {
                                Db::query(
                                    'DELETE FROM `sap_group_title` WHERE `id` = :id LIMIT 1',
                                    ['id' => $titleId]
                                );
                            } else {
                                Db::query(
                                    'UPDATE `sap_group_title` SET `name` = :name WHERE `id` = :id LIMIT 1',
                                    ['name' => $title, 'id' => $titleId]
                                );

                                if (isset($_POST['variations'][$titleId])) {
                                    foreach ($_POST['variations'][$titleId] as $variationId => $variation) {
                                        if ('' == $variation) {
                                            Db::query(
                                                'DELETE FROM `sap_group_title_variation` WHERE `id` = :id LIMIT 1',
                                                ['id' => $variationId]
                                            );
                                        } else {
                                            Db::query(
                                                'UPDATE `sap_group_title_variation`
                                                    SET `name` = :name
                                                  WHERE `id` = :id LIMIT 1',
                                                ['name' => $variation, 'id' => $variationId]
                                            );
                                        }
                                    }
                                }

                                if (isset($_POST['negatives'][$titleId])) {
                                    foreach ($_POST['negatives'][$titleId] as $negativeId => $keyword) {
                                        if ('' == $keyword) {
                                            Db::query(
                                                'DELETE FROM `sap_group_title_negative` WHERE `id` = :id LIMIT 1',
                                                ['id' => $negativeId]
                                            );
                                        } else {
                                            Db::query(
                                                'UPDATE `sap_group_title_negative`
                                                    SET `keyword` = :keyword
                                                  WHERE `id` = :id LIMIT 1',
                                                ['keyword' => $keyword, 'id' => $negativeId]
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            break;
    }
}

$groups = Db::fetchAll('SELECT * FROM sap_group ORDER BY sort_order ASC');

sapperView(
    'filter-titles',
    [
        'groups' => $groups
    ]
);