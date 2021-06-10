<?php
    include_once('../model/db_conn.php');
    include_once('../model/appointment.class.php');

    $dbh = Database::get_connection();

    $doctor_id = $_GET['doctor_id'];
    $date = format_date($_GET['date']);
    $available = (new Appointment($dbh))->getAvailableTimeSlots($date, $doctor_id);
    echo json_encode($available);


    function format_date($date) {
        $tokens = explode('/', $date);

        $date ='';
        foreach($tokens as $token) {
            $date .= $token.'/';
        }
        return substr($date,0, strlen($date) - 1);
    }