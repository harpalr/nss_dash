<?php
session_start();
if(!isset($_SESSION['nss_session_user'])){
    header("Location:logmein.php");
    exit;
}
require_once 'include/dbconnect.php';
require_once 'include/__route.php';

$route = new __route();
$reportName = $route->getFileName();
if(file_exists($reportName)){
    include ($reportName);
}else {
    echo "Report Not found";
    exit;
}

?>