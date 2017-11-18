<h4><a href="?controller=posts&action=index">Tillbaka</a></h4>
<?php
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post">
    Text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
    </form>';
}


foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><span class='mainpostsuser'>" . $user->getUsernameWithId($mainPostsValue['user_id']) . "</span> - " . $mainPostsValue['text'];

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 100);

    foreach ($subPosts as $subPostsKey => $subPostsValue) {

        echo "<div class='subposts'><div class='subpostsuser'>" .
        $user->getUsernameWithId($subPostsValue['user_id']) . " - " . $subPostsValue['created'] .
        "</div><div class='subpoststext'>" . $subPostsValue['text'] . "</div>";

            if ($subPostsValue['user_id'] == $userDetails['id']) {
                echo "<div class='subpostsedit'><a onclick='deletePost(" . $mainPostsValue['id'] . "," . $subPostsValue['id'] . ")' href='#'>delete</a>
                <a onclick='editPost(" . $mainPostsValue['id'] . "," . $subPostsValue['id'] . ")' href='#'>edit</a></div>";
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
