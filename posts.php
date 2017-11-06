<?php


class Posts
{

    function getPosts($type, $parent = null, $limit = 100, $id = null)
    {
        $db = new db();
        $query = "SELECT id,text,user_id FROM posts where deleted != 1 ";
        if ($type == "main") {
            $query .= "and type='main'";
        } else if ($type == "sub") {
            $query .= "and type='sub' and parent='$parent' order by id asc limit $limit";
        } else if ($type == "id") {
            $query .= "and type='main' and id = $id";
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
        $query = "SELECT id FROM posts where type='sub' and parent='$id' and deleted != 1";
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
        if ($text != '') {
            $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`) VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails['id'] . "')";
            if ($db->query($insert) === true) {
                if (isset($parent)) {
                    header('Location: index.php?action=viewpost&id=' . $parent);
                } else {
                    header('Location: index.php');
                }
            }
        }
        $db->close();
    }

    function deletePost($token, $id, $parent)
    {
        $db = new db();
        $user = new User();
        var_dump($token);
        if ($user->getUserDetails($token)) {

            $update = "UPDATE posts set deleted = '1' where id='$id'";
            if ($db->query($update) === TRUE) {
                header('Location: index.php?action=viewpost&id=' . $parent);
                exit;
            }

        }
    }


}