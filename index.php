<?php
require_once('controllers/require.php');

$user = new UserModel();
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '')
    $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'home';
}

if (!in_array($action, $controllerPagesSkipLayout[$controller])) {
    require_once('views/layout.php');
} else {
    require_once('routes.php');
}
?>