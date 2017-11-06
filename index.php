<?php
#error_reporting(-1);
#ini_set('display_errors', 'On');
require 'config.php';
require 'users.php';
require 'posts.php';
$user = new User();
$posts = new Posts();
$postid = $_GET["id"] ? "&id=" . $_GET["id"] : "";

if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    $userDetails = $user->getUserDetails($_COOKIE['usertoken']);
} else if (!$_GET["action"]) {
    header('Location: index.php?action=login');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h3><a href="index.php">Home</a></h3>
<?php
switch ($_GET["action"]) {
    case "login":
        if ($_GET["message"] == 1) {
            echo "<strong>Invalid username or password</strong>";
        }
        if ($_GET["message"] == 2) {
            echo "<strong>Error</strong>";
        }
        echo '
        <form action="index.php?action=loginreq" method="post">
        Username:<br>
        <input type="text" name="user"><br>
        Pass:<br>
        <input type="text" name="pass"><br>
        <input type="submit">
        </form>
        ';
        $mainPosts = $posts->getPosts('main');
        break;
    case "logout":
        $user->logout();
        break;
    case "loginreq":
        $user->login($_POST['user'], $_POST['pass']);
        break;
    case "viewpost":
        $mainPosts = $posts->getPosts('id', null, null, $_GET["id"]);
        break;
    case "createpost":
        $mainPosts = $posts->createPost($_POST['text'], $userDetails['token'], $_GET["id"]);
        break;
    default:
        $mainPosts = $posts->getPosts('main');
        break;
}

if (isset($userDetails['token'])) {
echo
'<h2>Hello '. $userDetails['username'].'</h2>
<h4><a href="index.php?action=logout">Logga ut</a></h4>
<form action="index.php?action=createpost' . $postid . '" method="post">
    text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
</form>
';
}
?>
<?php

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><a href='index.php?action=viewpost&id=" . $mainPostsValue['id'] . "'>" . $mainPostsValue['text'] . "</a>";

    if ($_GET["action"] != 'viewpost') {
        $subPosts = $posts->getSubPostAmount($mainPostsValue['id']);
        echo "<div class='subpostsDescription'>Inlägg: " . $subPosts . "</div>";
    } else {
        $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 100);
        foreach ($subPosts as $subPostsKey => $subPostsValue) {
            echo "<div class='subposts'>" . $subPostsValue['text'] . "</div>";
        }
    }

    echo "</div></div>";

}
?>

</body>
</html>