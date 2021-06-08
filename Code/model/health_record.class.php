<?php
require_once('db_conn.php');

class Health_Record {

    private $dbh = null;

    public function __construct($dbh){
        $this->dbh = $dbh;
    }

    public function addHealthRecord($prescription, $description, $written_by, $for_patient, $patient_diagnosis_id){
        $query = "INSERT INTO `health_records` (`prescription`, `description`, `date`, `written_by`, `for_patient`, `patient_diagnosis_id`) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(["approved", $prescription, $description, $written_by, $for_patient, $patient_diagnosis_id]);
    }

    public function getLatestPatientHealthRecord($patient_id) {
        //Prepare query and fetch result
        $stmt = $this->dbh->prepare("SELECT * FROM `health_records` WHERE `for_patient` = ? ORDER BY `date` DESC LIMIT 1;");
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
    public function getAllPatientHealthRecord($patient_id) {
        //Prepare query and fetch result
        $stmt = $this->dbh->prepare("SELECT * FROM `health_records` WHERE `for_patient` = ?");
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
    public function modifyHealthRecordPrescription($record_id, $change) {
        $query = "UPDATE `health_records` SET `prescription` = ? WHERE `$record_id` = ?";
        $stmt = $this->dbh->prepare($query);

        $stmt->execute([$change, $record_id]);
        $stmt = null;

    }
    public function modifyHealthRecordDescription($record_id, $change) {
        $query = "UPDATE `health_records` SET `description` = ? WHERE `$record_id` = ?";
        $stmt = $this->dbh->prepare($query);

        $stmt->execute([$change, $record_id]);
        $stmt = null;

    }
}