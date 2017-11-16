<?php

class User
{

    function login($username, $password)
    {
        if ($userToken = $this->authenticateUser($username, $password)) {
            if ($newToken = $this->updateUserToken($userToken)) {
                setcookie('usertoken', $newToken, time() + (86400), "/");
                return true;
            }
        }
    }

    function authenticateUser($username, $password)
    {
        $db = new db();
        $query = "SELECT token,password FROM users where username = '$username'";

        if ($result = $db->query($query)) {
            $userDetails = $result->fetch_assoc();
            if ($userDetails != NULL) {
                $hash = $userDetails['password'];
                if (password_verify($password, $hash))
                    return $userDetails['token'];
                else
                    return false;
            } else {
                return false;
            }
        }
    }

    function updateUserToken($token)
    {
        $db = new db();
        $newToken = $this->getNewHash();
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

    function createUser($username, $password)
    {
        $db = new db();
        $hash = $this->getNewHash($password);
        $newToken = $this->getNewHash();
        if (!$this->userExists($username)) {
            $insert = "INSERT INTO `users` (`id`, `username`, `password`, `token`) VALUES (NULL, '$username', '$hash', '$newToken')";
            if ($db->query($insert) === true) {
                return true;
            }
        }
        echo 'User already exist';
    }


    function changeUserPass($username, $password)
    {
        if ($userToken = $this->authenticateUser($username, $password)) {
            if ($newToken = $this->updateUserToken($userToken)) {
                setcookie('usertoken', $newToken, time() + (86400), "/");
                header('Location: index.php');
            }
        }
    }

    function getNewHash($input = null)
    {
        if (!$input) {
            $date = new DateTime();
            $input = $date->format('U');
        }
        return password_hash($input, PASSWORD_DEFAULT);

    }

    function userExists($username)
    {
        $db = new db();
        $query = "SELECT * FROM users where username='$username'";
        if ($result = $db->query($query)) {
            if ($result->num_rows > 0) {
                return true;
            }
            return false;
        }
    }

}

