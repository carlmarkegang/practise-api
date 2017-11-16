<?php
error_reporting(-1);
ini_set('display_errors', 'On');


function call($controller, $action)
{
    $className = $controller . 'Controller';
    require_once('controllers/' . $controller . '_controller.php');
    $controller = new $className();
    $controller->{$action}();
}

$controllers = array(
    'pages' => ['home', 'error'],
    'posts' => ['index', 'show', 'createpost', 'deletepost'],
    'login' => ['index', 'login', 'logout', 'createuser']
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