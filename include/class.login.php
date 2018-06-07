<?php

class Login {

    private $_conn;
    private $user_details;

    function __construct() {
        global $conn;
        $this->_conn = $conn;
    }

    public function authenticate($username, $password) {
        
        $sql = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'";
        $result = $this->_conn->query($sql);
        //var_dump($this->_conn);

        
        if ($result->num_rows > 0) {
            $this->user_details = $result->fetch_assoc();
            return true;
        }
        return false;
    }
    
    public function getUserDetails(){
        return $this->user_details;
    }

}

?>