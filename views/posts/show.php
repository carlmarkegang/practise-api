<?php

echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post">
    Text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
    </form>';

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'>" . $mainPostsValue['text'];

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 100);
    foreach ($subPosts as $subPostsKey => $subPostsValue) {
        echo "<div class='subposts'>" . $subPostsValue['text'];
        if ($subPostsValue['user_id'] == $userDetails['id']) {
            echo "<div><a onclick='deletePost(" . $mainPostsValue['id'] . "," . $subPostsValue['id'] . ")' href='#'>Delete</a></div>";
        }
        echo "</div>";
    }

    echo "</div></div>";

}
?>
<script>
    function deletePost(mainpost, subpost) {
        if (confirm("Are you sure you want to delete this post?") == true) {
            window.location.replace('index.php?controller=posts&action=deletepost&parent=' + mainpost + '&id=' + subpost);
        }
    }
</script>
