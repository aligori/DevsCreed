<?php
include_once('../model/appointment.class.php');
include_once('../model/db_conn.php');
include_once('../model/employee.class.php');

session_start();

if(isset($_SESSION['user_id']) && ($_SESSION['role'] === 'receptionist')) {
    $dbh = Database::get_connection();
    $query = '';
    $output = array();
    $query .= 'SELECT * FROM `appointment` as A INNER JOIN `service` as S on A.service_id = S.service_id';

    // Prepare query statement
    if(isset($_POST['search']['value'])) {
        $query .= 'WHERE full_name LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR phone LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR time LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR status LIKE "%'.$_POST["search"]["value"].'%"';
        $query .= 'OR service LIKE "%'.$_POST["search"]["value"].'%"';
    }

    $app = new Appointment($dbh);
    $result = $app->getAllAppointments($query);

    $data = $result[0];
    $filtered_rows = $result[1];
    $table = "";

    foreach($data as $row) {

        $employee = (new Employee($dbh))->getEmployee($row['doctor_id']);
        $table.='{
                      "full_name":"'.$row['full_name'].'",
                      "email":"'.$row['email'].'",
                      "phone":"'.$row['phone'].'",
                      "time":"'.$row['time'].'",
                      "doctor":"'.$employee['full_name'].'",
                      "status":"'.$row['status'].'",
                      "service":"'.$row['name'].'"
                    },';
    }
    $table = substr($table,0, strlen($table) - 1);
    echo '{"data":['.$table.']}';
} else {
    header("Location: ../login.php?error=Access Forbidden");
}
