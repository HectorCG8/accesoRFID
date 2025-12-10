<?php
session_start();

if (isset($_GET['msg'])) {
    $_SESSION['notificacion'] = $_GET['msg'];
    echo "OK";
}
?>
