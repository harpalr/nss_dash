<?php

class __route {

    public $request;

    public function __construct() {
        
    }

    public function getFileName() {
        $this->request = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 'all');
        
        switch ($this->request) {
            case 'all':
                return "reports/all_registrations.php";
                break;
            case 'login':
                return "include/login.php";
                break;
            case 'member':
                return "member";
                break;
            default:
                return "reports/all_registrations.phps";
                break;
        }
    }

}

?>