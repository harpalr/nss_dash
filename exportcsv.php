<?php
include("excelcolumnmapper.php");
include("processStatus.php");

$rowsArray = array(
    'main' => 'main',
    'primary' => 'Primary',
    'guest1' => 'Guest 1',
    'guest2' => 'Guest 2',
    'guest3' => 'Guest 3',
    'guest4' => 'Guest 4',
    'guest5' => 'Guest 5',
    'guest6' => 'Guest 6',
    'guest7' => 'Guest 7',
    'guest8' => 'Guest 8',
    'guest9' => 'Guest 9'
);

$membersArray = array(
    'primary' => 'Primary',
    'guest1' => 'Guest 1',
    'guest2' => 'Guest 2',
    'guest3' => 'Guest 3',
    'guest4' => 'Guest 4',
    'guest5' => 'Guest 5',
    'guest6' => 'Guest 6',
    'guest7' => 'Guest 7',
    'guest8' => 'Guest 8',
    'guest9' => 'Guest 9'
);

$patchArray = array(
    'guest3' => 'to/from ... 2',
    'guest4' => 'to/from ... 3',
    'guest5' => 'to/from ... 4',
    'guest6' => 'to/from ... 5',
    'guest7' => 'to/from ... 6',
    'guest8' => 'to/from ... 7',
    'guest9' => 'to/from ... 8',
    'guest2' => 'to/from ...',
);

if (isset($_POST["submit"])) {
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");
    processImport($handle);
}

function processImport($handle) {
    global $excel_headers_old, $membersArray, $patchArray;
    $row_counter = 0;
    $header_rec = getHeaders($handle);
    $memberDataArray = array();

    while (($data_set = fgetcsv($handle, 0, ",")) !== false) {
        
        if (validateMultipleReg($header_rec, $data_set)) {
            //echo "<script>updateStatics('Multiple Records')</script>";
        } else {
            //echo "SINGLE <br>";
        } 
        echo "<script>updateStatics('". ($row_counter + 1) ."')</script>";

        $traverse = 0;
        foreach ($excel_headers_old as $column_caption => $column) {
            $findMember = false;
            foreach ($membersArray as $member => $search_keyword) {
                $pos = strpos($column_caption, $search_keyword);
                if ($pos !== false) {
                    $memberDataArray[$row_counter][$member][$column] = $data_set[$traverse];
                    $findMember = true;
                    continue;
                }
            }
            //Patch Work
            if (!$findMember) {
                foreach ($patchArray as $member => $search_keyword) {
                    $pos = strpos($column_caption, $search_keyword);
                    if ($pos !== false) {
                        $memberDataArray[$row_counter][$member][$column] = $data_set[$traverse];
                        $findMember = true;
                        continue;
                    }
                }
            }
            if (!$findMember) {
                $memberDataArray[$row_counter]['main'][$column] = $data_set[$traverse];
            }
            $traverse++;
        }
        $finalArray = mergeArray($memberDataArray[$row_counter]['main'], $memberDataArray[$row_counter]['primary']);
        $memberDataArray[$row_counter]['main'] = refineDataRules($finalArray);
        createSqlInsert($memberDataArray[$row_counter]);
        $row_counter++;
    }
    //echo "<pre>";
    //print_r($memberDataArray);
}

//create insert sql
function createSqlInsert($dataArray) {
    $columnsList = createColumnList($dataArray['main']);

    $query = "INSERT INTO nss_registrations ";
    $query .= "(";
    $cols = "";
    foreach ($columnsList as $col) {
        $cols .= "$col,";
    }
    $query .= substr($cols, 0, -1) . ")";
    $query .= " VALUES ";
    //Loop through each regeistration
    $query .= createInsertSetStatement($dataArray, $columnsList);
    return substr($query, 0, -5);
}

//create insert set rule
function createInsertSetStatement($registration, $columnsList) {
    $str = "";
    $sameDataColumns = array('ip', 'submission_id', 'submission_date', 'unique_id');
    foreach ($registration as $member => $memberData) {
        if (!empty($memberData['first_name'])) {
            echo "<script>updateStatics('". ($memberData['first_name']) ."')</script>";

            $values = "(";
            foreach ($columnsList as $col) {
                if (in_array($col, $sameDataColumns)) {
                    $field_data = $registration['main'][$col];
                } else {
                    $field_data = (isset($memberData[$col]) ? $memberData[$col] : '');
                }
                $values .= "'" . $field_data . "',";
            }
            $str .= substr($values, 0, -1) . "),<br>";
        }
    }
    return $str;
}

function createColumnList($columns) {
    foreach ($columns as $column => $value) {
        $colArray[] = $column;
    }
    return $colArray;
}

//Data Rules
function refineDataRules($finalArray) {
    $ruleColumns = array('ground_transportation', 'legal');

    foreach ($ruleColumns as $column) {
        switch ($column) {
            case 'ground_transportation':
                $finalArray[$column] = (!empty($finalArray[$column]) ? "Yes" : "No");
                break;
            case 'legal':
                $finalArray[$column] = ((stripos($finalArray[$column], 'acknowledge') !== false) ? "Yes" : "No");
                break;
        }
    }
    return $finalArray;
}

// Merge Main and Primary Array into 1 
function mergeArray($main, $primary) {
    foreach ($main as $column => $value) {
        if (array_key_exists($column, $primary) && !empty($primary[$column])) {
            $finalArray [$column] = $primary[$column];
        } else {
            $finalArray [$column] = $value;
        }
        unset($primary[$column]);
    }
    return array_merge($finalArray, $primary);
}

// check for multiple registrations
function validateMultipleReg($header_rec, $data_set) {
    $key = array_search('Do you want to register Additional Guests?', $header_rec);

    if (isset($data_set[$key]) && strtoupper($data_set[$key]) == strtoupper('No, just me')) {
        return false;
    }
    return true;
}

// fetch headers from imported csv file
function getHeaders($handle) {
    if (($headers = fgetcsv($handle, 1000, ",") ) !== false) {
        return $headers;
    }
}

//CREATE TABLE STATEMENT
function createTableStatement($dataArray) {
    echo "CREATE TABLE nss_registration ( <br> id INT(6) AUTO_INCREMENT PRIMARY KEY,<br>";
    foreach ($dataArray as $column => $value) {
        echo "$column VARCHAR(100),<br>";
        ++$sum;
    }
    echo ")";
}
?>


<form name="import" method="post" enctype="multipart/form-data">
    <input type="file" name="file" /><br />
    <input type="submit" name="submit" value="Submit" />
</form>