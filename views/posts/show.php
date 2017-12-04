<?php
if (isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] != '') {
    echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post" enctype="multipart/form-data">
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit" onclick="if(!checkTextInput(this)){return false;}"> <input type="file" name="image">
    <div id="plzwritediv">Please write something</div>
    </form>';
}
?>
<div class='mainposts'>
<div id='mainpostswrap'>
<?php
$postLimit = 5;
foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

echo "<div class='subpostsDescription'><a href='?controller=user&action=view&id=" . $mainPostsValue['user_id'] . "'>" .
$user->getUsernameWithId($mainPostsValue['user_id']) . "</a> - " . $posts->time_elapsed_string($subPostsValue['converted_time']) .
"</div>" . $mainPostsValue['text'];

    $subPosts = $posts->getPosts('sub', $mainPostsValue['id'], $postLimit);

    foreach ($subPosts as $subPostsKey => $subPostsValue) {
        include("include/includeSubpost.php");
    }

}
?>
</div>
<?php
    if($posts->getSubPostAmount($mainPostsValue['id']) > $postLimit)
        echo '<span id="loadmoreposts" onclick="loadMorePosts(' . $postLimit . ')">Load more</span>';
?>
</div>
<script src="views/posts/post.js"></script>


