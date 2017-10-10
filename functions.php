<?php
#error_reporting(-1);
#ini_set('display_errors', 'On');
require('config.php');


class user
{

    function login($user, $pass)
    {
        $db = new db();
        $date = new DateTime();
        $token = password_hash($date->format('U'), PASSWORD_DEFAULT);
        $update = "UPDATE users set token = '$token' where password='$pass' and username = '$user'";
        if ($db->query($update)) {
            $query = "SELECT * FROM users where password='$pass' and username = '$user'";
            if ($result = $db->query($query)) {
                if ($result->num_rows === 0) {
                    header('Location: index.php?action=login&message=1');
                } else {
                    while ($row = $result->fetch_row()) {
                        setcookie('usertoken', $row[3], time() + (86400 * 30), "/"); // 86400 = 1 day
                        $result->close();
                        header('Location: index.php');
                    }
                }
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

#$user = new user();
#$user->login('carl','pass');

#sleep(5);
