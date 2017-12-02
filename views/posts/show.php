<?php
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post" enctype="multipart/form-data">
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="file" name="image">
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
            "</div>
            <div class='subpostscontentwrap'>";

        if ($subPostsValue['contains_img'])
            echo "<span class='subpostsimg'><a href='views/images/" . $subPostsValue['id'] . "." . $subPostsValue['contains_img'] . "' target='_blank'><img src='views/images/" . $subPostsValue['id'] . "." . $subPostsValue['contains_img'] . "'></span><a></span>";

        echo "<div class='subpoststext'>" . nl2br($subPostsValue['text']) . "</div>
            </div>";

        if ($subPostsValue['user_id'] == $userDetails['id'])
            include("userSpecific.php");

        echo "</div>";

    }

    echo "</div></div>";

}
?>

<style>
    .subpostsimg img {
        width: 150px;
        float: left;
        padding: 0 5px 5px 0;
    }

    .subpostscontentwrap {
        display: flex;
    }
</style>
<script src="views/posts/post.js"></script>


