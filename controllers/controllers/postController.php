<?php

class PostController extends PostModel
{

    function createPost($text, $token, $parent = '')
    {
        $db = new db();
        $date = date("y-m-d H:i:s");
        var_dump($date);
        $user = new UserModel();
        $userDetails = $user->getUserDetails($token);
        if ($parent == '') {
            $type = 'main';
        } else {
            $type = 'sub';
        }
        if ($text != '') {
            $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`, `deleted`) VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails['id'] . "', 0)";
            if ($db->query($insert) === true) {
                if (isset($parent)) {
                    header('Location: index.php?controller=posts&action=show&id=' . $parent);
                } else {
                    header('Location: index.php?controller=posts&action=index');
                }
            }
        }
        $db->close();
    }

    function deletePost($token, $id, $parent)
    {
        $db = new db();
        $user = new UserModel();
        if ($userdetails = $user->getUserDetails($token)) {
            $userid = $userdetails['id'];
            $update = "UPDATE posts set deleted = '1' where id='$id' and user_id = '$userid'";
            if ($db->query($update) === TRUE) {
                header('Location: index.php?controller=posts&action=show&id=' . $parent);
                exit;
            }

        }
    }


}