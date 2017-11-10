<?php

class User
{

    function login($username, $password)
    {
        if ($userToken = $this->authenticateUser($username, $password)) {
            if ($newToken = $this->updateUserToken($userToken)) {
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
                return false;
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
            header('Location: error.php');
            exit;
        }
    }

    function logout()
    {
        if (isset($_COOKIE['usertoken'])) {
            setcookie("usertoken", "", time() - 3600);
            return true;
        }
        return false;
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
        return false;
    }
}

