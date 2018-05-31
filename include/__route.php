<?php

class __route {

    public $request;

    public function __construct() {
        
    }

    public function getFileName() {
        $this->request = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 'all');
        
        switch ($this->request) {
            case 'all':
                return "all_registrations";
                break;
            case 'member':
                return "member";
                break;
            default:
                return "all_registrations";
                break;
        }
    }

}

?>