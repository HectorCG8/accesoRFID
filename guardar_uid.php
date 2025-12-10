<?php
if (isset($_GET['uid'])) {
    file_put_contents("uid_temp.txt", $_GET['uid']);
    echo "OK";
} else {
    echo "NO_UID";
}
?>
