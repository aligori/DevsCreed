<?php
    require_once('../db_conn.php');

    class Employee {

        public static function getEmployee($employee_id) {
            
            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `staff` WHERE employee_id = ?");
            $stmt->execute([$employee_id]);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$arr) exit('No rows');

            /*
            What will be returned: 
                                    `employee_id` 
                                    `full_name` 
                                    `email` 
                                    `phone` 
                                    `photo` 
                                    `birthday` 
                                    `salary` 
                                    `status` 
                                    `uuid`
            */

            //The stmt = null is a good coding practice.
            $stmt = null;
            var_export($arr);

        }

        public static function modifyEmployeeData($employee_id, $field, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET ? = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$field, $change, $employee_id]);
            $stmt = null;

        }

        public static function changeStatus($employee_id) {
            
            $dbh = (new Database())->get_connection();
            $currentStatus = getCurrentStatus($employee_id);

            // if condition, if status = 1 then it is active so make it 0
            // 0 represents an inactive account
            // if 0 reactivate

            if ($currentStatus == 1) {
                $query = "UPDATE `staff` SET `status` = 0 WHERE employee_id = ?";
              } else {
                $query = "UPDATE `staff` SET `status` = 1 WHERE employee_id = ?";
              }

            $stmt = $dbh->prepare($query);
            $stmt->execute([$employee_id]);
            $stmt = null;

        }

        // This function is used at changeStatus in order to get the current status of user
        private static function getCurrentStatus($employee_id){

            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT `status` FROM `staff` WHERE employee_id = ?");
            $stmt->execute([$employee_id]);
            $status = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;

            return $status['status'];
        }

    }