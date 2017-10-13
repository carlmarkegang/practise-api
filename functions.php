<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require 'config.php';


class User
{

    function login($username, $password)
    {
        $db = new db();
        $user = new User();
        $userToken = $user->authenticateUser($username, $password);
        $user->updateUserToken($userToken);
        $userDetails = $user->getUserDetails($userToken);
        setcookie('usertoken', $userDetails[0]['token'], time() + (86400), "/");
        header('Location: index.php');
        $db->close();
    }

    function authenticateUser($username, $password)
    {
        $db = new db();
        $query = "SELECT token FROM users where username = '$username' and password='$password'";
        if ($result = $db->query($query)) {
            $token = $result->fetch_assoc();
            #var_dump($token);
            if ($token != NULL) {
                return $token;
            } else {
                header('Location: index.php?action=login&message=1');
                exit;
            }
        }
    }

    function updateUserToken($token)
    {
        $db = new db();
        $date = new DateTime();
        $newToken = password_hash($date->format('U'), PASSWORD_DEFAULT);
        $update = "UPDATE users set token = '$newToken' where token='$token'";
        if ($db->query($update)) {
            return true;
        } else {
            header('Location: index.php?action=login&message=2');
            exit;
        }
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


class Posts
{

    function getPosts($type, $parent = null, $limit = 100, $id = null)
    {
        $db = new db();
        if ($type == "main") {
            $query = "SELECT id,text FROM posts where type='main'";
        } else if ($type == "sub") {
            $query = "SELECT id,text FROM posts where type='sub' and parent='$parent' order by id asc limit $limit";
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
        $user = new User();
        $userDetails = $user->getUserDetails($token);
        if ($parent == '') {
            $type = 'main';
        } else {
            $type = 'sub';
        }

        $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`) VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails[0]['id'] . "')";
        if ($db->query($insert) === true) {
            echo "success";
        }
        $db->close();
    }


}