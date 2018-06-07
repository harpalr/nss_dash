<?php

class all_registrations {

    private $total_records;
    private $data;
    private $_conn;

    function __construct() {
        global $conn;
        $this->_conn = $conn;
    }

    public function getAllRegistrants() {
        $sql = "SELECT reg.*, 
                count(sub.unique_id) as total
                FROM nss_registrations reg
                LEFT JOIN nss_registrations sub
                ON reg.unique_id = sub.unique_id
                GROUP BY reg.id";
        $result = $this->_conn->query($sql);
        $this->total_records = $result->num_rows;

        if ($this->total_records > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->data[] = $row;
            }
        }

        return $this->data;
    }

}

?>