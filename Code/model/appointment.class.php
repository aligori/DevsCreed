<?php
    require_once('db_conn.php');

    class Appointment {

        private $dbh = null;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }


        public function addNewAppointment($full_name, $email, $phone, $time, $doctor_id, $service_id, $patient_id, $status, $description) {
            $query = "INSERT INTO `appointment` (`full_name`, `email`, `phone`, `time`, `doctor_id`, `service_id`, `patient_id`, `status`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            return $stmt->execute([$full_name, $email, $phone, $time, $doctor_id, $service_id, $patient_id, $status, $description]);
        }

        public function  getNextAppointment($doctor_id) {
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `appointment` WHERE `time` > NOW() AND `doctor_id` = ? AND status = ? ORDER BY `time` asc LIMIT 1");
            $stmt->execute([$doctor_id, "approved"]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getAvailableTimeSlots($date, $doctor_id): array {
            $date .= "%";
            $query = "SELECT HOUR(time) AS hour FROM `appointment` WHERE `time` LIKE ? AND `doctor_id` = ? ORDER BY `time` asc";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$date, $doctor_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $busy = array();
            $timeslots = array("09", "10", "11", "12", "13", "14", "15", "16", "17", "18");

            foreach($rows as $time) {
                array_push($busy, $time['hour']);
            }

            return array_diff($timeslots, $busy);
        }

        public function getTodaysSchedule($doctor_id) {
            $date = date("Y-m-d");
            $date .= "%";

            $query = "SELECT * FROM `appointment` WHERE `time` LIKE ? AND `doctor_id` = ? ORDER BY `time` asc";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$date, $doctor_id]);
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getDoctorsAppointments($query, $doctor_id) {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$doctor_id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
            $result = array();
            array_push($result, $data);
            array_push($result, $rowCount);
            return $result;
        }

        public function getAllAppointments($query): array {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
            $result = array();
            array_push($result, $data);
            array_push($result, $rowCount);
            return $result;
        }

        public function addTransaction($transaction, $a_id){
            $query = "UPDATE `appointment` SET `transaction_id` = ? WHERE `a_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$transaction, $a_id]);
        }

        public function addService($service, $a_id){

            $query = "UPDATE `appointment` SET `service_id` = ? WHERE `a_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$service, $a_id]);
        }

        public  function getAppointmentDetails($a_id) {
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `appointment` WHERE `a_id` = ?");
            $stmt->execute([$a_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAppointmentRequests() {
            $stmt = $this->dbh->prepare("SELECT * FROM `appointment` WHERE `status` = 'requested'");
            $stmt->execute();
            $result = array();
            array_push($result, $stmt->fetchAll(PDO::FETCH_ASSOC));
            array_push($result, $stmt->rowCount());
            return $result;

        }

        public function manageRequest($a_id, $action, $doctor_id) {
            if ($action == "approved"){
                $query = "UPDATE `appointment` SET `doctor_id` = ?, `status` = ?, `service_id` = 1 WHERE a_id = ?";
                $stmt = $this->dbh->prepare($query);
                return $stmt->execute([$doctor_id,"approved", $a_id]);

            }else if ($action == "rejected") {
                $query = "UPDATE `appointment` SET `status` = 'rejected' WHERE a_id = ?";
                $stmt = $this->dbh->prepare($query);
                return $stmt->execute([$a_id]);
            }
        }

        public function completeAppointment($a_id) {
            $query = "UPDATE `appointment` SET `status` = 'completed' WHERE a_id = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$a_id]);
            $stmt = null;
        }

        public function  getNrAppointment($assigned_to, $time){
            $stmt = $this->dbh->prepare("SELECT COUNT(`a_id`) FROM `appointment` WHERE `doctor_id` = ? AND `time` = ?");
            $stmt->execute([$assigned_to, $time]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function reschedule($a_id, $doctor_id, $time) {
            $query = "UPDATE `appointment` SET `time` = ?, `doctor_id` = ?, `status` = 'approved' WHERE a_id = ?";
            $stmt = $this->dbh->prepare($query);
            return $stmt->execute([$time, $doctor_id, $a_id]);
        }

        public function cancelAppointment($a_id) {
            $query = "UPDATE `appointment` SET `status` = 'cancelled' WHERE a_id = ?";
            $stmt = $this->dbh->prepare($query);
            return $stmt->execute([$a_id]);
        }
    }