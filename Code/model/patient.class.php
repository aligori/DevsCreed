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

            $stmt = $this->dbh->prepare("SELECT * FROM `patient` WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');
            $stmt = null;
            return $arr;

        }

        public function getAllPatients($query): array {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
            $result = array();
            array_push($result, $data);
            array_push($result, $rowCount);
            $stmt = null;
            return $result;
        }

        public function registerPatient($full_name, $email, $phone, $birthday, $address, $status, $user_id) {
            $query = "INSERT INTO `patient` (`full_name`, `email`, `phone`, `birthday`, `address`, `status`, `user_id`)";
            $query .= " VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            return $stmt->execute([$full_name, $email, $phone, $birthday, $address, $status, $user_id]);
        }

        public function  getNrPatients(){
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT COUNT(`patient_id`) FROM `patient` WHERE `status` = 'active'");
            $stmt->execute([]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            //The stmt = null is a good coding practice.
            $stmt = null;
            return $arr;
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

        public function getPatientByEmail($email) {
            $stmt = $this->dbh->prepare("SELECT * FROM `patient` WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }