<?php
    require_once('db_conn.php');

    class Patient {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function addPatient($full_name, $email, $address, $phone, $birthday, $patient_diagnosis_id){
            $query = "INSERT INTO `patient` (`full_name`, `email`, `address`, `phone`, `birthday`, `patient_diagnosis_id`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$full_name, $email, $address, $phone, $birthday, $patient_diagnosis_id, "active"]);
        }

        public function getPatient($patient_id) {

            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `patient` WHERE patient_id = ?");
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

        public function  getNrPatients(){
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT COUNT(`patient_id`) FROM `patient` WHERE `status` = 'active'");
            $stmt->execute([]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;
        }

        public function modifyPatientName($patient_id, $change) {
            $query = "UPDATE `patient` SET `full_name` = ? WHERE `patient_id` = ?";
            $stmt = $this->dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public function modifyPatientEmail($patient_id, $change) {
            $query = "UPDATE `patient` SET `email` = ? WHERE `patient_id` = ?";
            $stmt = $this->dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public function modifyPatientAddress($patient_id, $change) {
            $query = "UPDATE `patient` SET `address` = ? WHERE `patient_id` = ?";
            $stmt = $this->dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public function modifyPatientPhone($patient_id, $change) {
            $query = "UPDATE `patient` SET `phone` = ? WHERE `patient_id` = ?";
            $stmt = $this->dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }

        public function modifyPatientBirthday($patient_id, $change)
        {
            $query = "UPDATE `patient` SET `birthday` = ? WHERE `patient_id` = ?";
            $stmt = $this->dbh->prepare($query);

            $stmt->execute([$change, $patient_id]);
            $stmt = null;

        }
    }