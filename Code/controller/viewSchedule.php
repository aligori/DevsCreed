<?php
include_once('../model/appointment.class.php');
include_once('../model/db_conn.php');
include_once('../model/user.class.php');

session_start();

if(isset($_SESSION['user_id']) && ($_SESSION['role'] === 'doctor')) {
    $dbh = Database::get_connection();
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    $query = '';
    $output = array();
    $query .= 'SELECT * FROM `appointment` as A INNER JOIN `service` as S on A.service_id = S.service_id WHERE doctor_id = ? ';

    // Prepare query statement
    if(isset($_POST['search']['value'])) {
        $query .= 'AND full_name LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR phone LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR time LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR status LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR service LIKE "%'.$_POST["search"]["value"].'%"';
    }

    if(isset($_POST['order'])) {
        $query .= 'ORDER BY'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'';
    } else {
        $query .= 'ORDER BY time ASC ';
    }

    $app = new Appointment($dbh);
    $result = $app->getDoctorsAppointments($query, $employee['employee_id']);

    $data = $result[0];
    $filtered_rows = $result[1];
    $table = "";

    foreach($data as $row) {

        $table.='{
                      "full_name":"'.$row['full_name'].'",
                      "email":"'.$row['email'].'",
                      "phone":"'.$row['phone'].'",
                      "time":"'.$row['time'].'",
                      "status":"'.$row['status'].'",
                      "service":"'.$row['name'].'",
                      "action":"No Action"
                    },';
    }
    $table = substr($table,0, strlen($table) - 1);
    echo '{"data":['.$table.']}';
} else {
    header("Location: ../login.php?error=Access Forbidden");
}
