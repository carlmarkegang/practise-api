<?php
echo
'<h2>Hello '. $userDetails['username'].'</h2>
<h4><a href="index.php?action=logout">Logga ut</a></h4>
<form action="index.php?action=createpost' . $postid . '" method="post">
    text:<br>
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit">
</form>
';

?>