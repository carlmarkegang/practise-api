<?php

class UserModel
{

    function authenticateUser($username, $password)
    {
        $db = new db();
        $query = "SELECT token,password FROM users where username = '$username'";

        if ($result = $db->query($query)) {
            $userDetails = $result->fetch_assoc();
            if ($userDetails != NULL) {
                if (password_verify($password, $userDetails['password']))
                    return $userDetails['token'];
            }
            return false;
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
        return false;
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

