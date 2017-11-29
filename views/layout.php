<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <link rel="stylesheet" type="text/css" href="views/style.css">
</head>
<body>
<div id='wrap'>
    <header>
        <a href='/'>Home</a>
        <a href='?controller=posts&action=index'>Posts</a>
        <?php
        if ($userDetails)
            echo "<a href='?controller=user&action=logout' id='login'>Logout</a>";
        else
            echo "<a href='?controller=user&action=index' id='login'>Login</a>";
        ?>
    </header>
    <?php require_once('routes.php'); ?>
</div>
</body>
<html>