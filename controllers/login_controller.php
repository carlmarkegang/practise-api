<?php

class LoginController
{
    public function index()
    {
        require_once('views/login/index.php');
    }

    public function login()
    {
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $user = new User();
            if (!$user->login($_POST['user'], $_POST['pass'])) {
                $errorMessage = 'Incorrect username or password';
                require_once('views/login/login.php');
            }
        }

    }

    public function logout()
    {
        $user = new User();
        $user->logout();
        require_once('views/login/logout.php');

    }
}

?>