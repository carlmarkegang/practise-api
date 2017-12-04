<?php
include_once("/var/www/forum/models/postModel.php");
include_once("/var/www/forum/models/userModel.php");
include_once("/var/www/forum/config.php");

$db = new db();
$posts = new PostModel();
$user = new UserModel();

$subPosts = $posts->getPosts('sub', 179,3, null, $_GET['offset']);

foreach ($subPosts as $subPostsKey => $subPostsValue) {
    include("/var/www/forum/views/posts/include/includeSubpost.php");
}

?>