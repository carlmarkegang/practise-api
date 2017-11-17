<?php

require_once('require.php');

class viewuserController
{
    public function index()
    {
        require_once('views/user/index.php');
    }

    public function login()
    {
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $userController = new UserController();
            if (!$userController->login($_POST['user'], $_POST['pass'])) {
                $errorMessage = 'Incorrect username or password';
                require_once('views/user/index.php');
            } else {
                header('Location: index.php');
            }
        }

    }

    public function createuser()
    {
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $userController = new UserController();
            if ($userController->createUser($_POST['user'], $_POST['pass'])) {
                echo 'User ' . $_POST['user'] . ' created';
                require_once('views/user/index.php');
            }
        } else {
            require_once('views/user/createuser.php');
        }

    }

    public function logout()
    {
        $userController = new UserController();
        $userController->logout();
        require_once('views/user/logout.php');
        header('Location: index.php');

    }
}

?>