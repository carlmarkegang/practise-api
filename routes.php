<?php
error_reporting(-1);
ini_set('display_errors', 'On');


function call($controller, $action)
{
    require_once('controllers/' . $controller . '_controller.php');
    require_once('models/users.php');
    switch ($controller) {
        case 'pages':
            $controller = new PagesController();
            break;
        case 'posts':
            $controller = new PostsController();
            break;
        case 'login':
            $controller = new LoginController();
            break;
    }

    $controller->{$action}();
}

$controllers = array(
    'pages' => ['home', 'error'],
    'posts' => ['index', 'show', 'createpost', 'deletepost'],
    'login' => ['index', 'login', 'logout']
);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('pages', 'error');
    }
} else {
    call('pages', 'error');
}
?>