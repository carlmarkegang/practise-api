<?php
echo "<span class='subpostsimg'>
<a href='views/images/" . $subPostsValue['id'] . "." . $subPostsValue['contains_img'] . "' target='_blank'>
<img src='views/images/" . $subPostsValue['id'] . "_thumb." . $subPostsValue['contains_img'] . "'></span>
</a></span>";
?>