<?php

use Sapper\Db,
    Sapper\Route,
    Sapper\User;

// permissions
if (!User::can('manage-users')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

// handle submissions
if ('POST' == $_SERVER['REQUEST_METHOD']) {

    switch (Route::uriParam('action')) {
        case 'create':
            if (0 == count($_POST['permissions'])) {
                Route::setFlash('danger', 'Please select at least 1 permission', $_POST);
            } else {
                try {
                    Db::insert(
                        'INSERT INTO `sap_role`
                                     (`name`, `permissions`)
                              VALUES (:name, :permissions)',
                        [
                            'name'        => $_POST['name'],
                            'permissions' => json_encode($_POST['permissions'], JSON_UNESCAPED_SLASHES)
                        ]
                    );

                    Route::setFlash('success', 'Role successfully created');
                } catch (Exception $e) {
                    if (false !== strpos($e->getMessage(), 'Duplicate')) {
                        Route::setFlash('danger', 'Role name already exists', $_POST);
                    } else {
                        Route::setFlash('danger', $e->getMessage(), $_POST);
                    }
                }
            }

            header('Location: /roles');
            exit;
            break;

        case 'edit':
            if (0 == count($_POST['permissions'])) {
                Route::setFlash('danger', 'Please select at least 1 permission', $_POST);
                header('Location: /roles/edit/' . Route::uriParam('id'));
                exit;
            } else {
                try {
                    Db::query(
                        'UPDATE `sap_role`
                            SET `name` = :name, `permissions` = :permissions
                          WHERE `id` = :id',
                        [
                            'name'        => $_POST['name'],
                            'permissions' => json_encode($_POST['permissions'], JSON_UNESCAPED_SLASHES),
                            'id'          => Route::uriParam('id')
                        ]
                    );

                    Route::setFlash('success', 'Role successfully saved');
                } catch (Exception $e) {
                    if (false !== strpos($e->getMessage(), 'Duplicate')) {
                        Route::setFlash('danger', 'Role name already exists', $_POST);

                        header('Location: /roles/edit/' . Route::uriParam('id'));
                        exit;
                    }
                }
            }

            header('Location: /roles');
            exit;
            break;
    }
}

// list pages
if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'edit':
            $role = Db::fetch(
                'SELECT * FROM sap_role WHERE id = :id',
                ['id' => Route::uriParam('id')]
            );

            $role['permissions'] = json_decode($role['permissions'], true);

            sapperView('roles-edit', ['role' => $role]);
            break;

        case 'delete':
            Db::query(
                'DELETE FROM sap_role WHERE id = :id',
                ['id' => Route::uriParam('id')]
            );

            Route::setFlash('success', 'Role successfully deleted');
            header('Location: /roles');
            break;
    }
} else {
    $roles = Db::fetchAll(
        sprintf(
            "SELECT r.*, COUNT(u.`id`) AS `countOfUsers`
           FROM `sap_role` r
      LEFT JOIN `sap_user` u ON r.`id` = u.`role_id`
          WHERE r.`name` != 'Super Admin'
       GROUP BY r.`id`"
        )
    );

    sapperView('roles', ['roles' => $roles]);
}