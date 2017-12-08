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

if (array_key_exists($controller, $controllerPages)) {
    if (in_array($action, $controllerPages[$controller])) {
        call($controller, $action);
    } else {
        call('pages', 'error');
    }
} else {
    call('pages', 'error');
}
?>