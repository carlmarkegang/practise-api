<script src="views/posts/post.js"></script>
<?php
if ($GLOBALS['userDetails'])
    include("include/includeResponseForm.php")
?>
<div class='mainposts'>
    <div id='mainpostswrap'>
        <?php
        foreach ($mainPosts as $mainPostsKey => $mainPostsValue) {
            echo "<div class='subpostsDescription'><a href='?controller=user&action=view&id=" . $mainPostsValue['user_id'] . "'>" .
                $user->getUsernameWithId($mainPostsValue['user_id']) . "</a> - " .
                $posts->time_elapsed_string($mainPostsValue['created']) .
                "</div>" . $mainPostsValue['text'];
        }
        ?>
    </div>
    <?php
    if ($posts->getSubPostAmount($mainPostsValue['id']) > $GLOBALS['postLimit'])
        echo '<span id="loadmoreposts" onclick="loadPosts(' . $mainPostsValue['id'] . "," . $GLOBALS['postLimit'] . "," . $GLOBALS['postLimit'] . ')">Load more</span>';

    echo '<script>loadPosts(' . $mainPostsValue['id'] . ',0,' . $GLOBALS['postLimit'] . ')</script>';
    ?>

</div>
