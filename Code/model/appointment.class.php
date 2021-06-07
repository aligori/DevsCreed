<?php
    require_once('db_conn.php');

    class Appointment {

        public static function getAppointmentDetails($a_id) {
            
            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = ($dbh)->prepare("SELECT * FROM `appointment` WHERE `a_id` = ?");
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

        public static function getAppointmentRequests() {

            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = ($dbh)->prepare("SELECT * FROM `appointment` WHERE `status` = 'requested'");
            $stmt->execute();
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;

        }



        public static function manageAppointmentRequests($a_id, $string, $employee_id) {
           
            $dbh = (new Database())->get_connection();

            if( strcmp($string, "approved") == 0){

                $query = "UPDATE `appointment` SET `status` = 'approved', `assigned_to` = ? WHERE a_id = ?";
                $stmt = $dbh->prepare($query);
                $stmt->execute([$employee_id, $a_id]);

            }else {
                // We use 0 as employee_id value for the case of rejected appointment
                $query = "UPDATE `appointment` SET `status` = 'rejected' WHERE a_id = ?";
                $stmt = $dbh->prepare($query);
                $stmt->execute([$a_id]);
            }            
            
            $stmt = null;

        }

        public static function setAppointmentToCompleted($a_id) {

            /*modify -> specify which field to modify(either doctor, time or status), specify new value to be entered and then executing*/
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `appointment` SET `status` = 'completed' WHERE a_id = ?";

            $stmt = $dbh->prepare($query);
            $stmt->execute([$a_id]);
            $stmt = null;

        }

        /*
        Used in rescheduling
        */

        public static function modifyAppointmentTime($a_id, $change) {

            /*modify -> specify which field to modify(either doctor, time or status), specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `appointment` SET `time` = ? WHERE a_id = ?";
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$change, $a_id]);
            $stmt = null;

        }

        public static function modifyAppointmentDoctor($a_id, $change) {

            /*modify -> specify which field to modify(either doctor, time or status), specify new value to be entered and then executing*/
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `appointment` SET `assigned_to` = ? WHERE a_id = ?";

            $stmt = $dbh->prepare($query);
            $stmt->execute([$change, $a_id]);
            $stmt = null;

        }

        public static function cancelAppointment($a_id) {

            /*modify -> specify which field to modify(either doctor, time or status), specify new value to be entered and then executing*/
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `appointment` SET `status` = 'cancelled' WHERE a_id = ?";

            $stmt = $dbh->prepare($query);
            $stmt->execute([$a_id]);
            $stmt = null;

        }

    }