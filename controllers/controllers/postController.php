<?php

class PostController extends PostModel
{

    function createPost($text, $token, $parent = '', $image = null)
    {
        $db = new db();
        $text = $this->makeSafe($text);
        $parent = $this->makeSafe($parent);
        $imageInsert = '';
        $date = date("d-m-Y H:i:s");
        $user = new UserModel();
        $userDetails = $user->getUserDetails($token);
        if ($parent == '') {
            $type = 'main';
        } else {
            $type = 'sub';
        }

        if ($image['size'] != 0) {
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

                if (isset($parent))
                    return $parent;
                else
                    return false;
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
        $text = $this->makeSafe($text);
        $parent = $this->makeSafe($parent);
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
        if ($image["size"] > 5000000) {
            echo 'too large';
            return false;
        }
        if (!in_array(strtolower($imagePath), array("jpg", "png", "jpeg", "gif"))) {
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
            $this->generateThumbnail($target_file, $imageId, $imageFileType);
            return true;
        }
    }

    function generateThumbnail($target_file, $imageId, $imageFileType)
    {
            $imagick = new Imagick(realpath($target_file));
            $target_file_thumb = "views/images/" . $imageId . '_thumb.' . $imageFileType;
            $imagick->thumbnailImage(150, 0, false, false);
            if (file_put_contents($target_file_thumb, $imagick) === false) {
                throw new Exception("Could not put contents.");
            }
            return true;
    }

    function makeSafe($input){
        return htmlspecialchars($input, ENT_QUOTES);
    }

}