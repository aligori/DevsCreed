<?php
require_once ('model/db_conn.php');
include 'model/appointment.class.php';

if(isset($_POST)) {
    session_start();
    $dbh = Database::get_connection();
    $app_class = new Appointment($dbh);
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    $nextApp = ($app_class)->getNextAppointment($employee["employee_id"]);
    var_dump($nextApp);
    die();
    $output = array();

    $output['full_name']=$nextApp['full_name'];
    $output['email']=$nextApp['email'];
    $output['phone']=$nextApp['phone'];
    $output['time']=$nextApp['time'];

    echo json_encode($output);
}