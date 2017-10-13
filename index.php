<?php
require 'functions.php';
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
    echo '
        <form action="index.php?action=loginreq" method="post">
        Username:<br>
        <input type="text" name="user"><br>
        Pass:<br>
        <input type="text" name="pass"><br>
        <input type="submit">
        </form>
        ';
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
    $mainPosts = $posts->createPost($_POST['text'], $userDetails[0]['token'], $_GET["id"]);
    if (isset($_GET["id"])) {
        header('Location: index.php?action=viewpost' . $postid);
    } else {
        header('Location: index.php');
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
    <title><?php echo $userDetails[0]['username'] ?></title>
    <style>
        .mainposts {
            background-color: #e8e8e8;
        }

        .subposts {
            padding-left: 20px;
        }
    </style>
</head>
<body>
<h3><a href="index.php">Home</a></h3>
<h2>Hello <?php echo $userDetails[0]['username'] ?></h2>

<form action="index.php?action=createpost<?php echo $postid ?>" method="post">
    text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
</form>
<?php

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><a href='index.php?action=viewpost&id=" . $mainPostsValue['id'] . "'><div class='mainposts'>" . $mainPostsValue['text'] . "</div></a>";

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 3);
    foreach ($subPosts as $subPostsKey => $subPostsValue) {
        echo "<div class='subposts'>" . $subPostsValue['text'] . "</div>";
    }

    echo "</div>";

}
?>

</body>
</html>