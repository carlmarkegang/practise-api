<DOCTYPE html>
    <html>
    <head>
        <title>Posts</title>
        <link rel="stylesheet" type="text/css" href="views/style.css">
    </head>
    <body>
    <header>
        <a href='/'>Home</a>
        <?php

        $user = new User();
        if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '')
            $userDetails = $user->getUserDetails($_COOKIE['usertoken']);

        if ($userDetails)
            echo "<a href='?controller=login&action=logout'>Logout</a>";
        else
            echo "<a href='?controller=login&action=index'>Login</a>";
        ?>
        <a href='?controller=posts&action=index'>Posts</a>
    </header>

    <?php require_once('routes.php'); ?>

    <body>
    <html>