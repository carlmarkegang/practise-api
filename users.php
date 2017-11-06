<?php

class User
{

    function login($username, $password)
    {
        $user = new User();
        if ($userToken = $user->authenticateUser($username, $password)) {
            if ($newToken = $user->updateUserToken($userToken)) {
                setcookie('usertoken', $newToken, time() + (86400), "/");
                header('Location: index.php');
            }
        }
    }

    function authenticateUser($username, $password)
    {
        $db = new db();
        $query = "SELECT token FROM users where username = '$username' and password='$password'";
        if ($result = $db->query($query)) {
            $token = $result->fetch_assoc();
            if ($token != NULL) {
                return $token['token'];
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
        if ($db->query($update) === TRUE) {
            return $newToken;
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
            $userDetails = $result->fetch_assoc();
            return $userDetails;
        }

    }
}

