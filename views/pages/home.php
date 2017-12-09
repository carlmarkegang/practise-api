<p>Home<p>

<?php

if (isset($GLOBALS['userDetails'])) {
    echo 'Hello ' . $GLOBALS['userDetails']['username'];
}

?>