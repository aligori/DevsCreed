<?php
    require_once('db_conn.php');

    class Employee {

        public static function getAllEmployees() {
            
            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `staff`");
            $stmt->execute();
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            return $arr;

        }

        public static function modifyEmployeeName($employee_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET `full_name` = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public static function modifyEmployeeEmail($employee_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET `email` = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public static function modifyEmployeePhone($employee_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET `phone` = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public static function modifyEmployeeBirthday($employee_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET `birthday` = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public static function modifyEmployeeSalary($employee_id, $change) {
            $dbh = (new Database())->get_connection();

            $query = "UPDATE `staff` SET `salary` = ? WHERE `employee_id` = ?";
            $stmt = $dbh->prepare($query);

            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public static function changeStatus($employee_id) {
            $dbh = (new Database())->get_connection();

            $stmt1 = $dbh->prepare("SELECT `status` FROM `staff` WHERE employee_id = ?");
            $stmt1->execute([$employee_id]);
            $status = $stmt1->fetch(PDO::FETCH_ASSOC);
            $stmt1 = null;

            $currentStatus = $status['status'];

            // if condition, if status = 1 then it is active so make it 0
            // 0 represents an inactive account
            // if 0 reactivate

            if (strcmp($currentStatus, "1") == 0) {

                $query = "UPDATE `staff` SET `status` = 0 WHERE employee_id = ?";
              } else {
                $query = "UPDATE `staff` SET `status` = 1 WHERE employee_id = ?";
              }

            $stmt = $dbh->prepare($query);
            $stmt->execute([$employee_id]);
            $stmt = null;
        }
    }