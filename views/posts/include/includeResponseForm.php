<?php
echo '<form action="index.php?controller=posts&action=createpost&id=' . $_GET['id'] . '" method="post" enctype="multipart/form-data">
    <textarea name="text" id="text" rows="5" cols="40"></textarea><br>
    <input type="submit" onclick="if(!checkTextInput(this)){return false;}"> <input type="file" name="image">
    <div id="plzwritediv">Please write something</div>
    </form>';
?>