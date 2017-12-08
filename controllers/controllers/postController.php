<?php

class PostController extends PostModel
{

    function createPost($text, $token, $parent = '', $image = null)
    {
        $db = new db();
        $user = new UserModel();
        $text = $this->makeSafe($text);
        $parent = $this->makeSafe($parent);
        $imageInsert = '';
        $date = time();
        $userDetails = $user->getUserDetails($token);
        $type = $parent == '' ? 'main' : 'sub';

        if ($image['size'] != 0) {
            if (!$imageInsert = $this->checkImage($image))
                return $imageInsert;
        }

        if ($text == '')
            return 'cannot make a empty post';

        $insert = "INSERT INTO `posts` (`id`, `text`, `type`, `parent`, `created`, `user_id`, `deleted`, `contains_img`) 
        VALUES (NULL, '$text', '$type', '$parent', '$date', '" . $userDetails['id'] . "', 0, '$imageInsert')";
        if ($db->query($insert) === true) {
            if ($image)
                $this->addImage($image, $db->insert_id, $imageInsert);

            return isset($parent) ? $parent : '';
        }
    }

    function deletePost($token, $id)
    {
        $db = new db();
        $user = new UserModel();
        $post = new PostModel();
        if ($userdetails = $user->getUserDetails($token)) {
            $userid = $userdetails['id'];
            $parent_id = $post->getParentIdFromSub($id);
            $update = "UPDATE posts set deleted = '1' where id='$id' and user_id = '$userid'";
            if ($db->query($update) === TRUE)
                return $parent_id;

        }
    }

    function editPost($token, $id, $text)
    {
        $db = new db();
        $user = new UserModel();
        $post = new PostModel();
        $text = $this->makeSafe($text);
        if ($userdetails = $user->getUserDetails($token)) {
            $userid = $userdetails['id'];
            $parent_id = $post->getParentIdFromSub($id);
            $update = "UPDATE posts set text = '" . $text . "' where id='$id' and user_id = '$userid'";
            if ($db->query($update) === TRUE)
                return $parent_id;

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

    function makeSafe($input)
    {
        return htmlspecialchars($input, ENT_QUOTES);
    }


}