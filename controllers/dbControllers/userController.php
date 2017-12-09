<?php

class UserController extends UserModel
{

    function login($username, $password)
    {
        $username = $this->makeSafe($username);
        $password = $this->makeSafe($password);
        if ($userToken = $this->authenticateUser($username, $password)) {
            if ($newToken = $this->updateUserToken($userToken)) {
                setcookie('usertoken', $newToken, time() + (86400), "/");
                return true;
            }
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

    function updateUserToken($token)
    {
        $db = new db();
        $newToken = $this->getNewHash();
        $update = "UPDATE users set token = '$newToken' where token='$token'";
        if ($db->query($update) === TRUE)
            return $newToken;
        else
            return false;
    }

    function createUser($username, $password)
    {
        $db = new db();
        $username = $this->makeSafe($username);
        $password = $this->makeSafe($password);
        $hash = $this->getNewHash($password);
        $newToken = $this->getNewHash();
        if (!$this->userExists($username)) {
            $insert = "INSERT INTO `users` (`id`, `username`, `password`, `token`) VALUES (NULL, '$username', '$hash', '$newToken')";
            if ($db->query($insert) === true)
                return true;

        }
        echo 'User already exist';
    }

    function getNewHash($input = null)
    {
        if (!$input) {
            $date = new DateTime();
            $input = $date->format('U');
        }
        return password_hash($input, PASSWORD_DEFAULT);

    }

    function makeSafe($input)
    {
        return htmlspecialchars($input, ENT_QUOTES);
    }

    function changeUserPass($username, $password)
    {

    }

}

