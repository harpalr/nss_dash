<?php

require_once 'include/dbconnect.php';
require_once 'include/__route.php';

$route = new __route();
$reportName = "reports/".$route->getFileName().".php";
if(file_exists($reportName)){
    include ("reports/".$route->getFileName().".php");
}else {
    echo "Report Not found";
    exit;
}

?>F