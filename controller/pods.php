<?php

use Sapper\Db,
    Sapper\Route,
    Sapper\User;

// permissions
if (!User::can('manage-clients')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

// handle submissions
if ('POST' == $_SERVER['REQUEST_METHOD']) {

    switch (Route::uriParam('action')) {
        case 'add':
            try {
                Db::insert(
                    'INSERT INTO `sap_pod`
                                     (`name`)
                              VALUES (:name)',
                    ['name' => $_POST['name']]
                );

                Route::setFlash('success', 'Pod successfully added');
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {
                    Route::setFlash('danger', 'Pod already exists', $_POST);
                } else {
                    Route::setFlash('danger', $e->getMessage(), $_POST);
                }
            }

            header('Location: /pods');
            exit;
            break;

        case 'edit':
            try {
                Db::query(
                    'UPDATE `sap_pod`
                          SET `name` = :name
                          WHERE `id` = :id',
                    [
                        'name'        => $_POST['name'],
                        'id'          => Route::uriParam('id')
                    ]
                );

                Route::setFlash('success', 'Pod successfully saved');
            } catch (Exception $e) {
                if (false !== strpos($e->getMessage(), 'Duplicate')) {
                    Route::setFlash('danger', 'Pod already exists', $_POST);
                }
            }
            header('Location: /pods/edit/' . Route::uriParam('id'));
            exit;
            break;
    }
}

if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'edit':
            $pod = Db::fetch(
                'SELECT * FROM sap_pod WHERE id = :id',
                ['id' => Route::uriParam('id')]
            );

            sapperView('pods-edit', ['pod' => $pod]);
            break;
        case 'delete':
            $usersCount = Db::fetchColumn(
                'SELECT COUNT(*) as `size` FROM `sap_user` WHERE `pod_id` = :id',
                ['id' => Route::uriParam('id')],
                'size'
            );

            if ($usersCount == 0) {
                Db::deleteById('pod', Route::uriParam('id'));
                Route::setFlash('success', 'Pod successfully deleted');
            } else {
                Route::setFlash('danger', 'Pod cannot be deleted because it is used');
            }

            header('Location: /pods');
            exit;
            break;
    }
} else {
    // List of all pods stored in the database
    $pods = Db::fetchAll(
            "SELECT p.`id`, p.`name`
             FROM `sap_pod` p
             ORDER BY p.`name` ASC"
    );

    sapperView('pods', ['pods' => $pods]);
}
