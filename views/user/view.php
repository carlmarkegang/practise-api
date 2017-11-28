<?php
echo "<h2>" . $username . "</h2>";

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><a href='index.php?controller=posts&action=show&id=" . $mainPostsValue['id'] . "'>" . $mainPostsValue['text'] . "</a>";
    echo "</div></div>";

}
?>