<?php

echo '<form action="index.php?controller=posts&action=createpost" method="post">
    Text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
    </form>';

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><a href='index.php?controller=posts&action=show&id=" . $mainPostsValue['id'] . "'>" . $mainPostsValue['text'] . "</a>";

    $subPosts = $posts->getSubPostAmount($mainPostsValue['id']);
    echo "<div class='subpostsDescription'>Inlägg: " . $subPosts . "</div>";


    echo "</div></div>";

}
?>