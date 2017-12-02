<?php

class PostController extends PostModel
{

    function createPost($text, $token, $parent = '', $image = null)
    {
        $imageInsert = '';
        $db = new db();
        $date = date("d-m-Y H:i:s");
        $user = new UserModel();
        $userDetails = $user->getUserDetails($token);
        if ($parent == '') {
            $type = 'main';
        } else {
            $type = 'sub';
        }

        if (isset($image)) {
            if (!$imageInsert = $this->checkImage($image)) {
                echo $imageInsert;
                return;
            }
        }

        if ($text != '') {
            $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`, `deleted`, `contains_img`) 
            VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails['id'] . "', 0, '$imageInsert')";

            if ($db->query($insert) === true) {
                if ($image)
                    $this->addImage($image, $db->insert_id, $imageInsert);

                if (isset($parent)) {
                    return $parent;
                } else {
                    return $db->insert_id;
                }
            }
            echo 'you cannot make a empty post';
        }
        return false;
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

    function editPost($token, $id, $parent, $text)
    {
        $db = new db();
        $user = new UserModel();
        if ($userdetails = $user->getUserDetails($token)) {
            $userid = $userdetails['id'];
            $update = "UPDATE posts set text = '" . $text . "' where id='$id' and user_id = '$userid'";
            if ($db->query($update) === TRUE) {
                header('Location: index.php?controller=posts&action=show&id=' . $parent);
                exit;
            }

        }
    }

    function checkImage($image)
    {
        $imagePath = pathinfo($image['name'], PATHINFO_EXTENSION);

        if (!$check = getimagesize($image["tmp_name"])) {
            echo 'not a image';
            return false;
        }
        if ($image["size"] > 500000) {
            echo 'too large';
            return false;
        }
        if (!in_array($imagePath, array("jpg", "png", "jpeg", "gif"))) {
            echo 'weird file ending';
            return false;
        }
        return $imagePath;
    }

    function addImage($image, $imageId, $imageFileType)
    {
        $target_file = "views/images/" . $imageId . '.' . $imageFileType;
        if (file_exists($target_file)) {
            return 'Exists';
        }
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return true;
        }
    }


}