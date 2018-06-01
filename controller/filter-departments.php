<?php

use Sapper\Db;
use Sapper\Route;

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    switch (Route::uriParam('method')) {
        case 'get-keywords':
            $keywords = Db::fetchAll(
                'SELECT * FROM `sap_department_keyword` WHERE `department_id` = :department_id ORDER BY `id` ASC',
                ['department_id' => (string) $_POST['id']]
            );

            jsonResponse($keywords);
            break;

        case 'delete':
            switch ($_POST['entity']) {
                case 'department':
                    $table = 'sap_department';
                    break;

                case 'keyword':
                    $table = 'sap_department_keyword';
                    break;
            }

            Db::query(
                "DELETE FROM $table WHERE `id` = :id",
                ['id' => $_POST['id']]
            );

            break;

        case 'add':
            switch ($_POST['entity']) {
                case 'department':
                    $id = Db::insert(
                        'INSERT INTO `sap_department` (`department`) VALUES (:department)',
                        ['department' => $_POST['department']]
                    );

                    jsonResponse(
                      ['id' => $id]
                    );
                    break;

                case 'keyword':
                    $id = Db::insert(
                        'INSERT INTO `sap_department_keyword` (`department_id`, `keyword`)
                              VALUES (:department_id, :keyword)',
                        [
                            'department_id' => $_POST['departmentId'],
                            'keyword'       => $_POST['keyword']
                        ]
                    );

                    jsonResponse(
                        ['id' => $id]
                    );
                    break;
            }
            break;

        case 'save':
            foreach ($_POST['departments'] as $departmentId => $department) {
                if ('' == $department) {
                    Db::query(
                        'DELETE FROM `sap_department` WHERE `id` = :id LIMIT 1',
                        ['id' => $departmentId]
                    );
                } else {
                    Db::query(
                        'UPDATE `sap_department` SET `department` = :department WHERE `id` = :id LIMIT 1',
                        [
                            'department' => $department,
                            'id'         => $departmentId
                        ]
                    );

                    if (isset($_POST['keywords'][$departmentId])) {
                        foreach ($_POST['keywords'][$departmentId] as $keywordId => $keyword) {
                            if ('' == $keyword) {
                                Db::query(
                                    'DELETE FROM `sap_department_keyword` WHERE `id` = :id LIMIT 1',
                                    ['id' => $keywordId]
                                );
                            } else {
                                Db::query(
                                    'UPDATE `sap_department_keyword` SET `keyword` = :keyword WHERE `id` = :id LIMIT 1',
                                    [
                                        'keyword' => $keyword,
                                        'id'      => $keywordId
                                    ]
                                );
                            }
                        }
                    }
                }
            }
            break;
    }
}

$departments = Db::fetchAll('SELECT * FROM sap_department ORDER BY department ASC');

sapperView(
    'filter-departments',
    [
        'departments' => $departments
    ]
);