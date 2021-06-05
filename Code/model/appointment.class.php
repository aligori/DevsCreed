<?php
    require_once('../db_conn.php');

    class Appointment {

        public static function getAllAppointments($a_id) {
            
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

        /*  Approval or rejection is just a set status operation */
        /*  If approved setDoctor()*/  
        // Needs REVIEW !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        public static function setStatus($a_id, $string, $employee_id) {
           
            $dbh = (new Database())->get_connection();

            if( $string == "approved"){

                $query = "UPDATE `appointment` SET `status` = 1, `assigned_to` = ? WHERE a_id = ?";
                $stmt = $dbh->prepare($query);
                $stmt->execute([$employee_id, $a_id]);

            }else {
                // We use 0 as employee_id value for the case of rejected appointment
                $query = "UPDATE `appointment` SET `status` = 0, `assigned_to` = 0 WHERE a_id = ?";
                $stmt = $dbh->prepare($query);
                $stmt->execute([$a_id]);
            }            
            
            $stmt = null;

        }
        
        /*
        Used in rescheduling
        */
        public static function modifyAppointment($a_id, $field, $change) {

            /*modify -> specify which field to modify(either doctor, time or status), specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `appointment` SET ? = ? WHERE a_id = ?";
            
            $stmt = $dbh->prepare($query);
            $stmt->execute([$field, $change, $a_id]);
            $stmt = null;

        }

    }