<?php

require_once('init.php');

// auth wall
if (!in_array(Sapper\Route::getController(), ['login', 'logout', 'privacy-policy', 'survey']) &&
    false == Sapper\Auth::validate()
) {
    Sapper\Route::setController('login');
} elseif (false == Sapper\Auth::validate() && !in_array(Sapper\Route::getController(), ['privacy-policy', 'survey'])) {
    Sapper\Route::setController('login');
}

// execute
Sapper\Route::run();
exit;

///////////////////////////////////////////////////////////////////////

function jsonResponse($data = []) {
    header('Content-type: application/json');
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

function jsonSuccess($data = []) {
    header('Content-type: application/json');
    echo json_encode(
        array_merge(
            ['status' => 'success'],
            ['data'   => $data]
        ),
        JSON_UNESCAPED_SLASHES
    );
    exit;
}

function jsonError($data = []) {
    header('Content-type: application/json');
    echo json_encode(
        array_merge(
            ['status' => 'error'],
            ['data'   => $data]
        ),
        JSON_UNESCAPED_SLASHES
    );
    exit;
}

function sapperView($view, $vars = []) {
    extract($vars);

    Sapper\Route::addBodyClass('view-' . $view);

    include_once('view/_header.php');
    include_once('view/' . $view . '.php');
    include_once('view/_footer.php');

    Sapper\Route::resetFlash();
    exit;
}