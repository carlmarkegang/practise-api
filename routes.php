<?php
#error_reporting(-1);
#ini_set('display_errors', 'On');

function call($controller, $action)
{
    $className = 'view' . $controller . 'Controller';
    require_once('controllers/view_' . $controller . '_controller.php');
    $controller = new $className();
    $controller->{$action}();

}

$controllers = array(
    'pages' => ['home', 'error'],
    'posts' => ['index', 'show', 'createpost', 'deletepost','editpost'],
    'user' => ['index', 'logout', 'createuser', 'view']
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