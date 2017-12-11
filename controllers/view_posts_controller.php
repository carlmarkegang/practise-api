<?php

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

        $mainPosts = $posts->getPosts('id', null, $GLOBALS['postLimit'], $_GET["id"]);
        require_once('views/posts/show.php');
    }

    public function createpost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);
        $return = $PostController->createPost($_POST['text'], $userDetails['token'], $_GET["id"], $_FILES["image"]);
        if ($return > 0)
            header('Location: index.php?controller=posts&action=show&id=' . $return);
        else
            header('Location: index.php?controller=posts&action=index');

    }

    public function deletepost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        if ($userDetails = $user->getUserDetails($_COOKIE['usertoken']))
            $postId = $PostController->deletePost($userDetails['token'], $_GET["id"]);
        header('Location: index.php?controller=posts&action=show&id=' . $postId);
    }

    public function editpost()
    {
        $user = new UserModel();
        $PostController = new PostController();
        if ($userDetails = $user->getUserDetails($_COOKIE['usertoken']))
            $postId = $PostController->editPost($userDetails['token'], $_GET["id"], $_POST['text']);
        header('Location: index.php?controller=posts&action=show&id=' . $postId);
    }

    public function loadpost()
    {
        $db = new db();
        $posts = new PostModel();
        $user = new UserModel();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

        $subPosts = $posts->getPosts('sub', $_GET['parent'], $_GET['offsetstatic'], null, $_GET['offset']);

        foreach ($subPosts as $subPostsKey => $subPostsValue) {
            include("views/posts/include/includeSubpost.php");
        }

    }

}

?>