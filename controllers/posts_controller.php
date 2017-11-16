<?php

class postsController
{
    public function index()
    {
        require_once('models/posts.php');
        $posts = new Posts();
        $mainPosts = $posts->getPosts('main');
        require_once('views/posts/index.php');
    }

    public function show()
    {
        require_once('models/posts.php');
        $posts = new Posts();
        $user = new User();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

        if (!isset($_GET['id']))
            return call('pages', 'error');

        $mainPosts = $posts->getPosts('id', null, null, $_GET["id"]);
        require_once('views/posts/show.php');
    }

    public function createpost()
    {
        require_once('models/posts.php');
        require_once('models/users.php');
        $user = new User();
        $posts = new Posts();
        $userDetails = $user->getUserDetails($_COOKIE['usertoken']);
        $posts->createPost($_POST['text'], $userDetails['token'], $_GET["id"]);
    }

    public function deletepost()
    {
        require_once('models/posts.php');
        require_once('models/users.php');
        $user = new User();
        $posts = new Posts();
        if ($userDetails = $user->getUserDetails($_COOKIE['usertoken']))
            $posts->deletePost($userDetails['token'], $_GET["id"], $_GET["parent"]);
    }
}

?>