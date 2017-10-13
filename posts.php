<?php


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

        $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`) VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails['id'] . "')";
        if ($db->query($insert) === true) {
            echo "success";
        }
        $db->close();
    }


}