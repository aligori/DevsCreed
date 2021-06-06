<?php
    require_once('../db_conn.php');

    class Patient {

        public static function getPatient($patient_id) {

            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `patient` WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            /*
            What will be returned:
                           `patient_id`
                           `full_name`
                           `email`
                           `address`
                           `phone`
                           `birthday`
            */

            //The stmt = null is a good coding practice.
            $stmt = null;
            var_export($arr);

        }

        public static function modifyPatientName($patient_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `patient` SET `full_name` = ? WHERE `patient_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public static function modifyPatientEmail($patient_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `patient` SET `email` = ? WHERE `patient_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public static function modifyPatientAddress($patient_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `patient` SET `address` = ? WHERE `patient_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public static function modifyPatientPhone($patient_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `patient` SET `phone` = ? WHERE `patient_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public static function modifyPatientBirthday($patient_id, $change)
        {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `patient` SET `birthday` = ? WHERE `patient_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }
    }