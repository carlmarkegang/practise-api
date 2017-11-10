<?php
require_once('config.php');
require_once('models/users.php');

$user = new User();
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '')
    $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'home';
}

require_once('views/layout.php');
?>