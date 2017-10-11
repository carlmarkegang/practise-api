<?php
#error_reporting(-1);
#ini_set('display_errors', 'On');
require('config.php');


class user
{

    function login($username, $password)
    {
        $db = new db();
        $date = new DateTime();
        $user = new user();
        $token = password_hash($date->format('U'), PASSWORD_DEFAULT);
        $update = "UPDATE users set token = '$token' where password='$password' and username = '$username'";
        if ($db->query($update)) {
            $userDetails = $user->getUserDetails($token);
            if ($userDetails != NULL) {
                setcookie('usertoken', $userDetails[0]['token'], time() + (86400), "/");
                header('Location: index.php');
            } else {
                header('Location: index.php?action=login&message=1');
            }
        }
        $db->close();
    }

    function logout()
    {
        if (isset($_COOKIE['usertoken'])) {
            setcookie("usertoken", "", time() - 3600);
        }
    }

    function getUserDetails($token)
    {
        $db = new db();
        $decodedToken = urldecode($token);
        $query = "SELECT * FROM users where token='$decodedToken'";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }
}


class posts
{

    function getPosts($type, $parent = null, $limit = 100, $id = null)
    {
        $db = new db();
        if ($type == "main") {
            $query = "SELECT id,text FROM posts where type='main'";
        } else if ($type == "sub") {
            $query = "SELECT id,text FROM posts where type='sub' and parent='$parent' order by id desc limit $limit";
        } else if ($type == "id") {
            $query = "SELECT id,text FROM posts where type='main' and id = $id";
        }

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }


    function createPost($text, $token, $parent = '')
    {
        $db = new db();
        $date = date("y-m-d");
        $user = new user();
        $userDetails = $user->getUserDetails($token);
        if ($parent==''){$type = 'main';} else {$type = 'sub';}

        $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`) VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails[0]['id'] . "')";
        if ($db->query($insert) === TRUE) {
            echo "success";
        }
        $db->close();
    }


}