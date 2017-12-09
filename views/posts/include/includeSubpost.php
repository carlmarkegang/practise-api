<?php
echo "<div class='subposts'><div class='subpostsuser'>" .
    "<a href='?controller=user&action=view&id=" . $subPostsValue['user_id'] . "'>" .
    $user->getUsernameWithId($subPostsValue['user_id']) .
    "</a>" . " - " . $posts->time_elapsed_string($subPostsValue['converted_time']) .
    "</div><div class='subpostscontentwrap'>";

if ($subPostsValue['contains_img'])
    include("/var/www/forum//views/posts/include/includeImage.php");

echo "<div class='subpoststext'>" . nl2br($subPostsValue['text']) . "</div></div>";

if ($subPostsValue['user_id'] == $userDetails['id'])
    include("/var/www/forum//views/posts/include/includeUserMenuBar.php");

echo "</div>";
?>