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

    function getSubPostAmount($id = null)
    {
        $db = new db();
        $query = "SELECT id,text FROM posts where type='sub' and parent='$id'";
        if ($result = $db->query($query)) {
            $rowCount = $result->num_rows;
            return $rowCount;
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
            if (isset($parent)) {
                header('Location: index.php?action=viewpost&id=' . $parent);
            } else {
                header('Location: index.php');
            }
        }
        $db->close();
    }


}