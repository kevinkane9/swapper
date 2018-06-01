<?php

use Sapper\Db,
    Sapper\Route,
    Sapper\Auth;

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $action = $_POST['action'];
} else {
    $action = 'view';
}

switch ($action) {
    case 'view':
        $user = Db::fetch(
            'SELECT * FROM `sap_user` WHERE `id` = :id',
            ['id' => Auth::token('userId')]
        );
        sapperView(
            'my-profile',
            [
                'user' => $user
            ]
        );
        break;

    case 'save':
        try {
            Db::query(
                'UPDATE `sap_user`
                            SET `email` = :email, `first_name` = :first_name, `last_name` = :last_name
                          WHERE `id` = :id',
                [
                    'email'       => $_POST['email'],
                    'first_name'  => $_POST['first_name'],
                    'last_name'   => $_POST['last_name'],
                    'id'          => $_POST['id']
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
                        'id'       => $_POST['id']
                    ]
                );
            }

            Route::setFlash('success', 'Profile successfully saved');
        } catch (Exception $e) {
            if (false !== strpos($e->getMessage(), 'Duplicate')) {
                Route::setFlash('danger', 'Email address already in use', $_POST);
            } else {
                Route::setFlash('danger', $e->getMessage(), $_POST);
            }
        }

        header('Location: /my-profile');
        exit;
        break;
}