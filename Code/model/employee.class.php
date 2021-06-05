<?php
    require_once('../db_conn.php');

    class Employee {

        //private static $dbh = (new Database())->get_connection();

        public static function getEmployee($employee_id) {
            
            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = dbh->prepare("SELECT * FROM `staff` WHERE employee_id = ?");
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
            var_export($arr);
            //The stmt = null is a good coding practice.
            $stmt = null;
            
        }

        public static function modifyEmployeeData($employee_id, $field, $change) {
            /*modify -> specify which field to modify, specify new value to be entered and then executing*/ 
           
            $query = "UPDATE `staff` SET ? = ? WHERE id = ?";
            
            $stmt = $this->$dbh->prepare($query);
            $stmt->execute([$field, $change, $employee_id]);
            $stmt = null;

        }

        public function changeStatus($employee_id) {
            
            $currentStatus = getCurrentStatus($employee_id);

            // if condition, if status = 1 then it is active so make it 0
            // 0 represents an inactive account
            // if 0 reactivate

            if ($currentStatus == 1) {
                $query = "UPDATE `staff` SET `status` = 0 WHERE id = ?";
              } else {
                $query = "UPDATE `staff` SET `status` = 1 WHERE id = ?";
              }

            $stmt = $this->$dbh->prepare($query);
            $stmt->execute([$employee_id]);
            $stmt = null;

        }

        // This function is used at changeStatus in order to get the current status of user
        private function getCurrentStatus($employee_id){

            $stmt = $this->$dbh->prepare("SELECT `status` FROM `staff` WHERE employee_id = ?");
            $stmt->execute([$employee_id]);
            $status = $stmt->fetch(PDO::FETCH_ASSOC);

            var_export($status);
            $stmt = null;
        } 
    }