<?php
    require_once('db_conn.php');

    class Appointment {

        private $dbh = null;

        public function __construct(){
            $this->dbh = (new Database())->get_connection();
        }

        public  function getAppointmentDetails($a_id) {
            //Prepare query and fetch result
            $stmt = ($this->dbh)->prepare("SELECT * FROM `appointment` WHERE `a_id` = ?");
            $stmt->execute([$a_id]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            /*
            What will be returned: 
                                    `a_id` 
                                    `status` 
                                    `time` 
                                    `assigned_to` 
                                    `booked_by` 
                                    `transaction_id` 
                                    `service_id`
            */

            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;
            
        }

        public function getAppointmentRequests() {

            //Prepare query and fetch result
            $stmt = ($this->dbh)->prepare("SELECT * FROM `appointment` WHERE `status` = 'requested'");
            $stmt->execute();
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;

        }



        public function manageAppointmentRequests($a_id, $string, $employee_id) {
            if( strcmp($string, "approved") == 0){

                $query = "UPDATE `appointment` SET `status` = 'approved', `assigned_to` = ? WHERE a_id = ?";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute([$employee_id, $a_id]);

            }else {
                // We use 0 as employee_id value for the case of rejected appointment
                $query = "UPDATE `appointment` SET `status` = 'rejected' WHERE a_id = ?";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute([$a_id]);
            }            
            
            $stmt = null;
        }

        public function setAppointmentToCompleted($a_id) {
            $query = "UPDATE `appointment` SET `status` = 'completed' WHERE a_id = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$a_id]);
            $stmt = null;
        }

        /*
        Used in rescheduling
        */

        public function modifyAppointmentTime($a_id, $change) {
            $query = "UPDATE `appointment` SET `time` = ? WHERE a_id = ?";
            
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $a_id]);
            $stmt = null;

        }

        public function modifyAppointmentDoctor($a_id, $change) {
            $query = "UPDATE `appointment` SET `assigned_to` = ? WHERE a_id = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $a_id]);
            $stmt = null;

        }

        public function cancelAppointment($a_id) {
            $query = "UPDATE `appointment` SET `status` = 'cancelled' WHERE a_id = ?";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$a_id]);
            $stmt = null;
        }
    }