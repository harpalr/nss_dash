<?php

$servername = "https://www.nirankari.org/phpMyAdmin3/index.php";
$username = "nirankar_events";
$password = "Houston@Nss#2018";
$dbname = "nirankar_eventreg";


//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "nss";
//
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>