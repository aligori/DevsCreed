<?php
    include_once('../model/db_conn.php');
    include_once('../model/appointment.class.php');
    include_once('../model/patient.class.php');
    include('../utils/helpers.php');

    $dbh = Database::get_connection();

        $full_name = $_POST['name'];
        $email = $_POST['email'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $patient = null;
        $phone = null;
        $doctor_id = null;
        $patient_id = null;
        $service_id = null;
        $status = "requested";
        $description = null;

        $date .= ' '.$time.':00:00';

        if($_POST['doctor_id']) {
            $doctor_id = $_POST['doctor_id'];
            $status = "approved";
        }

        if($_POST['email']) {
            $patient = (new Patient($dbh))->getPatientByEmail($_POST['email']);
            if($patient) {
                $patient_id = $patient['patient_id'];
                $phone = $patient['phone'];
            } else {
                $phone = $_POST['phone'];
            }
        }

        if($_POST['service_id']) {
            $service_id = $_POST['service_id'];
        }

        if($_POST['desc']) {
            $description = $_POST['desc'];
        }

        $result = (new Appointment($dbh))->addNewAppointment($full_name, $email, $phone, $date, $doctor_id, $service_id, $patient_id, $status, $description);

        if ($result) {
            header("Location: ../receptionist-scheduleAppointment.php?success=Successfully scheduled appointment!");
        } else {
            header("Location: ../receptionist-scheduleAppointment.php?error=There was a problem in adding this appointment!");
        }