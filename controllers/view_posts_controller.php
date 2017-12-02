<?php

require_once('require.php');

class viewpostsController
{
    public function index()
    {
        $posts = new PostModel();
        $mainPosts = $posts->getPosts('main');
        require_once('views/posts/index.php');
    }

    public function show()
    {
        $posts = new PostModel();
        $user = new UserModel();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

        if (!isset($_GET['id']))
            return call('pages', 'error');

        $mainPosts = $posts->getPosts('id', null, null, $_GET["id"]);
        require_once('views/posts/show.php');
    }

    public function createpost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);
        if ($return = $PostController->createPost($_POST['text'], $userDetails['token'], $_GET["id"], $_FILES["image"]))
            header('Location: index.php?controller=posts&action=show&id=' . $return);
        else
            header('Location: index.php?controller=posts&action=index');
    }

    public function deletepost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        if ($userDetails = $user->getUserDetails($_COOKIE['usertoken']))
            $PostController->deletePost($userDetails['token'], $_GET["id"], $_GET["parent"]);
    }

    public function editpost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        if ($userDetails = $user->getUserDetails($_COOKIE['usertoken']))
            $PostController->editPost($userDetails['token'], $_GET["id"], $_GET["parent"], $_POST['text']);
    }
}

?>