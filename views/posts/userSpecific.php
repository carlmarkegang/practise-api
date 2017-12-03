<?php
echo '<form action="index.php?controller=posts&action=editpost&parent=' . $mainPostsValue['id'] . '&id=' . $subPostsValue['id'] . '" method="post" class="subpostsedittext" style="display:none;">
<textarea name="text" id="text" rows="5" cols="40">' . $subPostsValue['text'] . '</textarea><br>
<input type="submit"> <span class="subpostcanceledit" onclick="cancelEditPost(this)">Cancel</span>
</form>';

echo "<div class='subpostsedit'>
<span onclick='deletePost(" . $mainPostsValue['id'] . "," . $subPostsValue['id'] . ")' href='#'>delete</span>
<span onclick='editPost(this)' href='#'>edit</span>
</div>";
?>