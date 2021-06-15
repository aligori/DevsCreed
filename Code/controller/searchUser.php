<?php
include_once('../model/user.class.php');
include_once('../model/db_conn.php');

$dbh = Database::get_connection();
$query = '';
$output = array();
$query .= 'SELECT * FROM `user_account`';

// Prepare query statement
if(isset($_POST['search']['value'])) {
    $query .= 'WHERE name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR surname LIKE "%'.$_POST["search"]["value"].'%"';
}

if(isset($_POST['order'])) {
    $query .= 'ORDER BY'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'';
} else {
    $query .= 'ORDER BY user_id ASC ';
}

$emp = new Users($dbh);
$result = $emp->getAllUserAccounts($query);
$data = $result[0];
$filtered_rows = $result[1];
$table = "";
foreach($data as $row) {
    $edit = '<a href=\"edit.php?a='.$row['user_id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\">Edit</a>';
    $table.='{
                      "user_id":"'.$row['user_id'].'",
                      "name":"'.$row['name'].'",
                      "surname":"'.$row['surname'].'",
                      "role":"'.$row['role'].'",
                      "username":"'.$row['username'].'"
                    },';
}
$table = substr($table,0, strlen($table) - 1);
echo '{"data":['.$table.']}';