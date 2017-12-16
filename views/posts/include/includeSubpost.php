<?php
echo "<div class='subposts'><div class='subpostsuser'>" .
    "<a href='?controller=user&action=view&id=" . $subPostsValue['user_id'] . "'>" .
    $user->getUsernameWithId($subPostsValue['user_id']) .
    "</a>" . " - " . $posts->time_elapsed_string($subPostsValue['created']);

if ($subPostsValue['updated'] != "")
    echo " <span class='subpostsedited'>edited:" . $posts->time_elapsed_string($subPostsValue['updated']) . "</span>";

echo "</div><div class='subpostscontentwrap'>";

if ($subPostsValue['contains_img'])
    include("includeImage.php");

echo "<div class='subpoststext'>" . nl2br($subPostsValue['text']) . "</div></div>";

if ($subPostsValue['user_id'] == $userDetails['id'])
    include("includeUserMenuBar.php");

echo "</div>";
?>