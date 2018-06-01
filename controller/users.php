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
                    $salt = md5(time());
                    $pass = md5($_POST['userPassword'] . $salt);

                    $insert = Db::insert(
                        'INSERT INTO `sap_user`
                                    (`email`, `first_name`, `last_name`, `role_id`, `pod_id`, `permissions`, `password`, `salt`)
                             VALUES (:email, :first_name, :last_name, :role_id, :pod_id, :permissions, :password, :salt)',
                        [
                            'email'       => $_POST['userEmail'],
                            'first_name'  => $_POST['first_name'],
                            'last_name'   => $_POST['last_name'],
                            'pod_id'      => empty($_POST['pod_id']) ? null : $_POST['pod_id'],
                            'role_id'     => $_POST['role_id'],
                            'permissions' => json_encode($_POST['permissions'], JSON_UNESCAPED_SLASHES),
                            'password'    => $pass,
                            'salt'        => $salt
                        ]
                    );

                    Route::setFlash('success', 'User successfully created');
                } catch (Exception $e) {
                    if (false !== strpos($e->getMessage(), 'Duplicate')) {
                        Route::setFlash('danger', 'Email address already in use', $_POST);
                    } else {
                        throw new Exception($e->getMessage());
                    }
                }
            }

            header('Location: /users/add');
            exit;
            break;

        case 'edit':
            if (0 == count($_POST['permissions'])) {
                Route::setFlash('danger', 'Please select at least 1 permission', $_POST);
                header('Location: /users/edit/' . Route::uriParam('id'));
                exit;
            } else {
                try {
                    Db::query(
                        'UPDATE `sap_user`
                            SET `email` = :email, `first_name` = :first_name, `last_name` = :last_name,
                                `role_id` = :role_id, `pod_id` = :pod_id, `status` = :status, `permissions` = :permissions
                          WHERE `id` = :id',
                        [
                            'email'       => $_POST['email'],
                            'first_name'  => $_POST['first_name'],
                            'last_name'   => $_POST['last_name'],
                            'pod_id'      => empty($_POST['pod_id']) ? null : $_POST['pod_id'],
                            'role_id'     => $_POST['role_id'],
                            'status'      => $_POST['status'],
                            'permissions' => json_encode($_POST['permissions'], JSON_UNESCAPED_SLASHES),
                            'id'          => Route::uriParam('id')
                        ]
                    );

                    if (!empty($_POST['userPassword'])) {
                        $salt = md5(time());
                        $password = md5($_POST['userPassword'] . $salt);

                        Db::query(
                            'UPDATE `sap_user` SET `password` = :password, `salt` = :salt WHERE `id` = :id',
                            [
                                'password' => $password,
                                'salt'     => $salt,
                                'id'       => Route::uriParam('id')
                            ]
                        );
                    }

                    Route::setFlash('success', 'User successfully saved');
                } catch (Exception $e) {
                    if (false !== strpos($e->getMessage(), 'Duplicate')) {
                        Route::setFlash('danger', 'Email address already in use', $_POST);
                    } else {
                        Route::setFlash('danger', $e->getMessage(), $_POST);
                    }

                    header('Location: /users/edit/' . Route::uriParam('id'));
                    exit;
                }
            }

            header('Location: /users');
            exit;
            break;

        case 'get-role':
            $role = Db::fetch(
                'SELECT `permissions` FROM `sap_role` WHERE `id` = :id',
                ['id' => $_POST['id']]
            );

            jsonResponse(['permissions' => json_decode($role['permissions'], true)]);
            break;
    }
}

// list of all roles
$roles = Db::fetchAll('SELECT * FROM sap_role WHERE `name` != "Super Admin" ORDER BY `name` ASC');

// List of all pods stored in the database to add to the POD drop down list
$pods = Db::fetchAll('SELECT `id`, `name` FROM `sap_pod` ORDER BY `name`  ASC');

if (Route::uriParam('action')) {
    switch (Route::uriParam('action')) {
        case 'edit':
            $user = Db::fetch(
                'SELECT * FROM `sap_user` WHERE `id` = :id',
                ['id' => Route::uriParam('id')]
            );
            $user['permissions'] = json_decode($user['permissions'], true);

            sapperView('users-edit', ['user' => $user, 'roles' => $roles, 'pods' => $pods]);
            break;
        case 'add':
            $users = Db::fetchAll(
                "SELECT u.*, r.`name` AS `role`
                FROM `sap_user` u
            LEFT JOIN `sap_role` r ON u.`role_id` = r.`id`
                WHERE u.`id` != :id AND r.`name` != 'Super Admin'",
                ['id' => Sapper\Auth::token('userId')]
            );
        
            sapperView('users-add', ['users' => $users, 'roles' => $roles, 'pods' => $pods]);
            break;
        case 'delete':
            Db::query(
                'DELETE FROM `sap_user` WHERE `id` = :id',
                ['id' => Route::uriParam('id')]
            );

            Route::setFlash('success', 'User successfully deleted');
            header('Location: /users');
            break;
    }
} else {
    $users = Db::fetchAll(
        "SELECT u.*, r.`name` AS `role`, p.`name` as pod
         FROM `sap_user` u
         LEFT JOIN `sap_pod` p ON u.`pod_id` = p.`id`
         LEFT JOIN `sap_role` r ON u.`role_id` = r.`id`
         WHERE u.`id` != :id AND r.`name` != 'Super Admin'",
        ['id' => Sapper\Auth::token('userId')]
    );

    sapperView('users', ['users' => $users, 'roles' => $roles, 'pods' => $pods]);
}