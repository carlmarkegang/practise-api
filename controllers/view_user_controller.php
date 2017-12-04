<?php

require_once('require.php');

class viewuserController
{
    public function index()
    {
        require_once('views/user/index.php');

        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $userController = new UserController();
            if (!$userController->login($_POST['user'], $_POST['pass'])) {
                echo '<br>Incorrect username or password<br>';
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
        header('Location: index.php');

    }

    public function view()
    {
        $posts = new PostModel();
        $user = new UserModel();
        $id = $_GET["id"];

        $username = $user->getUsernameWithId($id);
        $mainPosts = $posts->getUserSpecificMainPosts($id, 5);
        $subPosts = $posts->getUserSpecificSubPosts($id, 5);
        require_once('views/user/view.php');
    }
}

?>