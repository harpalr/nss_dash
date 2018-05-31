<?php

class all_registrations{
    
    function __construct() {
        global $conn;
        $sql = "SELECT * FROM nss_registrations";
        if ($conn->query($sql) !== true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
}

?>