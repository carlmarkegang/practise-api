<?php
require_once('models/userModel.php');
require_once('config.php');



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

require_once('views/layout.php');
?>