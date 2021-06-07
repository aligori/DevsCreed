<?php
require_once('../db_conn.php');

class Health_Record {

    public static function getLatestPatientHealthRecord($patient_id) {
        //Prepare query and fetch result
        $dbh = (new Database())->get_connection();
        $stmt = $dbh->prepare("SELECT * FROM `health_records` WHERE `for_patient` = ? ORDER BY `date` DESC LIMIT 1;");
        $stmt->execute([$patient_id]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$arr) exit('No rows');

        /*
        What will be returned:
                       `record_id`
                       `prescription`
                       `description`
                       `date`
                       `written_by`
                       `for_patient`
                       `patient_diagnosis_id`
        */

        //The stmt = null is a good coding practice.
        $stmt = null;
        var_export($arr);

    }
    public static function getAllPatientHealthRecord($patient_id) {
        //Prepare query and fetch result
        $dbh = (new Database())->get_connection();
        $stmt = $dbh->prepare("SELECT * FROM `health_records` WHERE `for_patient` = ?");
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
    public static function modifyHealthRecordPrescription($record_id, $change) {
        $dbh = (new Database())->get_connection();

        $query = "UPDATE `health_records` SET `prescription` = ? WHERE `$record_id` = ?";
        $stmt = $dbh->prepare($query);

        $stmt->execute([$change, $record_id]);
        $stmt = null;

    }
    public static function modifyHealthRecordDescription($record_id, $change) {
        $dbh = (new Database())->get_connection();

        $query = "UPDATE `health_records` SET `description` = ? WHERE `$record_id` = ?";
        $stmt = $dbh->prepare($query);

        $stmt->execute([$change, $record_id]);
        $stmt = null;

    }
}