<?php
require('functions.php');
$user = new user();

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
    default:
        #echo "Your favorite color is neither red, blue, nor green!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $userDetails[0]['username'] ?></title>
</head>
<body>
<h2>Hello <?php echo $userDetails[0]['username'] ?></h2>

</body>
</html>