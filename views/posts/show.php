<?php
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post">
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
    </form>';
}


foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><span class='mainpostsuser'>
    <a href='?controller=user&action=view&id=" . $mainPostsValue['user_id'] . "'>" . $user->getUsernameWithId($mainPostsValue['user_id']) . "</a>
    </span> - " . $mainPostsValue['text'];

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], 100);

    foreach ($subPosts as $subPostsKey => $subPostsValue) {

        echo "<div class='subposts'><div class='subpostsuser'>" .
            "<a href='?controller=user&action=view&id=" . $subPostsValue['user_id'] . "'>" . $user->getUsernameWithId($subPostsValue['user_id']) . "</a>" . " - " . $subPostsValue['created'] .
            "</div><div class='subpoststext'>" . nl2br($subPostsValue['text']) . "</div>";

        if ($subPostsValue['user_id'] == $userDetails['id'])
            include("userSpecific.php");

        echo "</div>";

    }

    echo "</div></div>";

}
?>
<script src="views/posts/post.js"></script>


