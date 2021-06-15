<?php
    require_once("../model/db_conn.php");
    require_once("../model/appointment.class.php");
    $dbh = Database::get_connection();
    $ap = new Appointment($dbh);

    if(isset($_POST['modal_reject_button'])) {
        $a_id = $_POST['cancel_a_id'];
        $result = ($ap)->manageRequest($a_id, "rejected", null);

        if ($result) {
            header("Location: ../receptionist-manage-requests.php?success=Appointment rejected!");
        } else {
            header("Location: ../receptionist-manage-requests.php?success=An error has occurred");
        }
    } else if(isset($_POST['modal_approve_button'])) {
        $a_id = $_POST['approve_a_id'];
        $doctor_id = $_POST['doctor_id'];
        $result = ($ap)->manageRequest($a_id,"approved", $doctor_id);

        if ($result) {
            header("Location: ../receptionist-manage-requests.php?success=Appointment approved successfully!");
        } else {
            header("Location: ../receptionist-manage-requests.php?success=An error has occurred");
        }

    } else if(isset($_POST['modal_reschedule_button'])) {
        $a_id = $_POST['reschedule_a_id'];
        $doctor_id = $_POST['doctor_id'];
        $date = $_POST['date_r'];
        $time = $_POST['time_r'];
        $date .= ' '.$time.':00:00';

        $result = ($ap)->reschedule($a_id, $doctor_id, $date);

        if ($result) {
            header("Location: ../receptionist-manage-requests.php?success=Appointment rescheduled!");
        } else {
            header("Location: ../receptionist-manage-requests.php?success=An error has occurred");
        }
    }