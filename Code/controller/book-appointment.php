<?php
    include_once('../model/db_conn.php');
    include_once('../model/appointment.class.php');
    $dbh = Database::get_connection();

    if ($_POST) {
        $full_name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['date'];
        $time = $_POST['time'];
//        $description = $_POST['description'];
        $doctor_id = null;
        $patient_id = null;
        $service_id = null;
        $status = "requested";
        $description = $_POST['description'];

        if($_POST['doctor_id']) {
            $doctor_id = $_POST['doctor_id'];
            $status = "approved";
        }

        if($_POST['patient_id']) {
            $patient_id = $_POST['patient_id'];
        }

        if($_POST['service_id']) {
            $service_id = $_POST['service_id'];
        }

        $result = (new Appointment($dbh))->addNewAppointment($full_name, $email, $phone, $date, $time, $doctor_id, $service_id, $patient_id, $status, $description);

//        if ($result) {
//            return
//        }

}