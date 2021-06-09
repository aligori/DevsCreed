<?php
include_once('../model/patient.class.php');
include_once('../model/db_conn.php');

$dbh = Database::get_connection();
$query = '';
$output = array();
$query .= 'SELECT * FROM `patient`';

// Prepare query statement
if(isset($_POST['search']['value'])) {
    $query .= 'WHERE full_name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%"';
}

if(isset($_POST['order'])) {
    $query .= 'ORDER BY'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'';
} else {
    $query .= 'ORDER BY patient_id ASC ';
}

$pt = new Patient($dbh);
$result = $pt->getAllPatients($query);
$data = $result[0];
$filtered_rows = $result[1];
$table = "";
foreach($data as $row) {
    $edit = '<a href=\"edit.php?a='.$row['patient_id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\">Edit</a>';
    $table.='{
                      "patient_id":"'.$row['patient_id'].'",
                      "full_name":"'.$row['full_name'].'",
                      "email":"'.$row['email'].'",
                      "phone":"'.$row['phone'].'",
                      "birthday":"'.$row['birthday'].'",
                      "address":"'.$row['address'].'",
                      "status":"'.$row['status'].'",
                      "edit": "'.$edit.'"
                    },';
}
$table = substr($table,0, strlen($table) - 1);
echo '{"data":['.$table.']}';