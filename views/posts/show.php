<?php

echo
    '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post">
text:<br>
<textarea name="text" id="text" rows="5" cols="40"></textarea><br>
<input type="submit">
</form>';

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'>" . $mainPostsValue['text'];

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 100);
    foreach ($subPosts as $subPostsKey => $subPostsValue) {
        echo "<div class='subposts'>" . $subPostsValue['text'];
        if ($subPostsValue['user_id'] == $userDetails['id']) {
            echo "<div><a href='index.php?controller=posts&action=deletepost&id=" . $subPostsValue['id'] . "&parent=" . $mainPostsValue['id'] . "'>Delete</a></div>";
        }
        echo "</div>";
    }

    echo "</div></div>";

}
?>