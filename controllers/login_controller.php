<?php

class loginController
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
                require_once('views/login/index.php');
            } else {
                header('Location: index.php');
            }
        }

    }

    public function createuser()
    {

        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $user = new User();
            if ($user->createUser($_POST['user'], $_POST['pass'])) {
                echo 'User ' . $_POST['user'] . ' created';
                require_once('views/login/index.php');
            }
        } else {
            require_once('views/login/createuser.php');
        }

    }

    public function logout()
    {
        $user = new User();
        $user->logout();
        require_once('views/login/logout.php');
        header('Location: index.php');

    }
}

?>