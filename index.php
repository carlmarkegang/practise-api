<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require 'config.php';
require 'users.php';
require 'posts.php';
$user = new User();
$posts = new Posts();
$postid = $_GET["id"] ? "&id=" . $_GET["id"] : "";

if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    $userDetails = $user->getUserDetails($_COOKIE['usertoken']);
    echo '<h4><a href="index.php?action=logout">Logga ut</a></h4>';
} else if (!$_GET["action"]) {
    header('Location: index.php?action=login');
}

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
        header('Location: index.php');
        break;
    case "loginreq":
        $user->login($_POST['user'], $_POST['pass']);
        break;
    case "viewpost":
        $mainPosts = $posts->getPosts('id', null, null, $_GET["id"]);
        break;
    case "createpost":
        if(isset($userDetails['token'])){
        $mainPosts = $posts->createPost($_POST['text'], $userDetails['token'], $_GET["id"]);
        if (isset($_GET["id"])) {
            header('Location: index.php?action=viewpost' . $postid);
        } else {
            header('Location: index.php');
        }
        }
        break;
    default:
        $mainPosts = $posts->getPosts('main');
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $userDetails['username']; ?></title>
    <style>
        .mainposts {
            font-size: 20px;
            font-family: sans-serif;
            background-color: #e8e8e8;
            padding: 20px;
            border: 1px dotted black;
            margin: 10px;
        }

        .subposts {
            font-size: 14px;
        }

        a {
            color: #313131;
        }

        a:hover {
            color: #828282;
        }
    </style>
</head>
<body>
<h3><a href="index.php">Home</a></h3>
<h2>Hello <?php echo $userDetails['username']; ?></h2>
<?php
if(isset($userDetails['token'])) {
echo '
<form action="index.php?action=createpost<?php echo $postid ?>" method="post">
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
        echo "<div class='subposts'>Inlägg: " . $subPosts . "</div>";
    }

    echo "</div></div>";

}
?>

</body>
</html>