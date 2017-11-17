<p>Home<p>

<?php

$user = new UserModel();
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '')
    $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

if (isset($userDetails)) {

    echo 'Hello ' . $userDetails['username'];

}

?>