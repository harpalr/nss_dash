<?php

session_start();
if (isset($_SESSION['nss_session_user'])) {
    session_destroy();
    unset($_SESSION['nss_session_user']);
    header("Location:logmein.php");
    exit;
}
?>