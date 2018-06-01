<?php

if ('POST' == $_SERVER['REQUEST_METHOD'] && array_key_exists('doLogin', $_POST)) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = 'Missing request parameter';
    } else {
        if (false == Sapper\Auth::authenticate($_POST['email'], $_POST['password'])) {
            $error = 'Invalid email and/or password';
        } else {
            header('Location: /home');
            exit;
        }
    }
}

include_once(APP_ROOT_PATH . '/view/login.php');
exit;