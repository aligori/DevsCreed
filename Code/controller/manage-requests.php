<?php
    require_once("../model/db_conn.php");
    require_once("../model/appointment.class.php");
    $dbh = Database::get_connection();
    $ap = new Appointment($dbh);

    if(isset($_POST['modal_reject_button'])) {
        $a_id = $_POST['cancel_a_id'];
        $result = ($ap)->cancelAppointment($a_id);

        if ($result) {
            header("Location: ../receptionist-manage-requests.php?success=Appointment rejected!");
        } else {
            header("Location: ../receptionist-manage-requests.php?success=An error has occurred");
        }
    } else if(isset($_POST['modal_approve_button'])) {
        $a_id = $_POST['approve_a_id'];
        $doctor_id = $_POST['doctor_id'];

        $result = ($ap)->assignDoctor($a_id, $doctor_id);

        if ($result) {
            header("Location: ../receptionist-manage-requests.php?success=Appointment approved successfully!");
        } else {
            header("Location: ../receptionist-manage-requests.php?success=An error has occurred");
        }
    }