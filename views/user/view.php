
<?php
echo "<h2>" . $username . "</h2>
<h3>Trådar</h3>";

foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {

    echo "<div><div class='mainposts'><a href='index.php?controller=posts&action=show&id=" . $mainPostsValue['id'] . "'>" . $mainPostsValue['text'] . "</a>";
    echo "</div></div>";

}

?>

<h3>Svar</h3>

<?php
foreach ($subPosts as $subPostsKey => $subPostsValue) {

    $mainPost = $posts->getPosts('id', null, null, $subPostsValue['parent']);
    echo "<div class='subposts'><a href='index.php?controller=posts&action=show&id=" . $subPostsValue['parent'] . "'>" . $mainPost[0]['text'] . "</a><br>";
    echo nl2br($subPostsValue['text']) . "</div>";

}
?>