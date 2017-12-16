<?php
echo "<h2>" . $username . "</h2>";
?>

<div id="changepass" class="subpostsedit">
    <span onclick='displayChangePass(this)'>Change password</span>
    <form action="?controller=user&action=changepass" id="changepassform" method="post">
        Pass:<br>
        <input type="text" name="pass"><br>
        New Pass:<br>
        <input type="text" name="newpass"><br>
        <input type="submit">
    </form>
</div>

<div class='alignleft'><h3>Threads</h3>
    <?php
    foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {
        echo "<div><div class='mainposts'><a href='index.php?controller=posts&action=show&id=" . $mainPostsValue['id'] . "'>" . $mainPostsValue['text'] . "</a> " .
            "<span class='created'>" . $posts->time_elapsed_string($mainPostsValue['created']) . "</span>";
        echo "</div></div>";
    }

    if (count($mainPosts) == 0)
        echo 'No threads';

    ?>
</div>
<div class='alignleft'>
    <h3>Replies</h3>
    <?php
    foreach ($subPosts as $subPostsKey => $subPostsValue) {
        $mainPost = $posts->getPosts('id', null, 1, $subPostsValue['parent']);
        echo "<div class='subposts'><a href='index.php?controller=posts&action=show&id=" . $subPostsValue['parent'] . "'>" . $mainPost[0]['text'] . "</a> " .
            "<span class='created'>" . $posts->time_elapsed_string($subPostsValue['created']) . "</span><br>" .
            nl2br($subPostsValue['text']) . "</div>";
    }

    if (count($subPosts) == 0)
        echo 'No replies';
    ?>
</div>
<script src="views/user/user.js"></script>
