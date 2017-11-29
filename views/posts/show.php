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
            "<a href='?controller=user&action=view&id=" . $mainPostsValue['user_id'] . "'>" . $user->getUsernameWithId($mainPostsValue['user_id']) . "</a>" . " - " . $subPostsValue['created'] .
            "</div><div class='subpoststext'>" . nl2br($subPostsValue['text']) . "</div>";

        if ($subPostsValue['user_id'] == $userDetails['id']) {

            echo '<form action="index.php?controller=posts&action=editpost&parent=' . $mainPostsValue['id'] . '&id=' . $subPostsValue['id'] . '" method="post" class="subpostsedittext" style="display:none;">
                <textarea name="text" id="text" rows="5" cols="40">' . $subPostsValue['text'] . '</textarea><br>
                <input type="submit"> <span class="subpostcanceledit" onclick="cancelEditPost(this)">Cancel</span>
                </form>';

            echo "<div class='subpostsedit'><a onclick='deletePost(" . $mainPostsValue['id'] . "," . $subPostsValue['id'] . ")' href='#'>delete</a>
                <a onclick='editPost(this)' href='#'>edit</a></div>";

        }
        echo "</div>";

    }

    echo "</div></div>";

}
?>
<script>
    function deletePost(mainpost, subpost) {
        if (confirm("Are you sure you want to delete this post?") == true) {
            window.location.replace('index.php?controller=posts&action=deletepost&parent=' + mainpost + '&id=' + subpost);
        }
    }

    function editPost(element) {
        element.parentElement.parentElement.getElementsByClassName("subpoststext")[0].style.display = "none";
        element.parentElement.parentElement.getElementsByClassName("subpostsedittext")[0].style.display = "block";
    }

    function cancelEditPost(element) {
        element.parentElement.parentElement.getElementsByClassName("subpoststext")[0].style.display = "block";
        element.parentElement.parentElement.getElementsByClassName("subpostsedittext")[0].style.display = "none";
    }
</script>


