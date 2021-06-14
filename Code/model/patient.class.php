<?php
    require_once('db_conn.php');

    class Patient {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function getPatientById($patient_id) {
            $stmt = $this->dbh->prepare("SELECT * FROM `patient` WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
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
            $stmt = $this->dbh->prepare("SELECT COUNT(`patient_id`) as cnt FROM `patient` WHERE `status` = 'active'");
            $stmt->execute([]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
            return $count;
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

        public function getDiagnosis($patient_id) {
            $query = "SELECT * FROM `patient_diagnosis` as PD INNER JOIN `diagnosis` as D on PD.diagnosis_id = D.diagnosis_id  WHERE patient_id = ? and isCurrent = 'current'";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$patient_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }