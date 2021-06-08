<?php

    class Employee {

        private $dbh;

        public function __construct($dbh) {
            $this->dbh = $dbh;
        }

        public function getAllEmployees($query): array {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
            $result = array();
            array_push($result, $data);
            array_push($result, $rowCount);
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
            return $result;
        }

        function get_total_all_records(): int {
            $stmt = $this->dbh->prepare("SELECT * FROM `staff`");
            $stmt->execute();
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->rowCount();
        }

        public function registerEmployee($full_name, $email, $position, $phone, $birthday, $salary, $address, $status, $user_id) {
            $query = "INSERT INTO `staff` (`full_name`, `email`, `position`, `phone`, `birthday`, `salary`, `address`, `status`, `user_id`)";
            $query .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            return $stmt->execute([$full_name, $email, $position, $phone, $birthday, $salary, $address, $status, $user_id]);
        }

        public function getEmployee($employee_id) {
            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `staff` WHERE `employee_id` = ?");
            $stmt->execute($employee_id);
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);

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

        public function modifyEmployeeName($employee_id, $change) {
            $query = "UPDATE `staff` SET `full_name` = ? WHERE `employee_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public function modifyEmployeeEmail($employee_id, $change) {
            $query = "UPDATE `staff` SET `email` = ? WHERE `employee_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public function modifyEmployeePhone($employee_id, $change) {
            $query = "UPDATE `staff` SET `phone` = ? WHERE `employee_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public function modifyEmployeeBirthday($employee_id, $change) {
            $query = "UPDATE `staff` SET `birthday` = ? WHERE `employee_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public  function modifyEmployeeSalary($employee_id, $change) {
            $query = "UPDATE `staff` SET `salary` = ? WHERE `employee_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$change, $employee_id]);
            $stmt = null;

        }
        public function changeStatus($employee_id) {
            $currentStatus = $this->getCurrentStatus($employee_id);
            // if condition, if status = 1 then it is active so make it 0
            // 0 represents an inactive account
            // if 0 reactivate

            if (strcmp($currentStatus, "1") == 0) {
                $query = "UPDATE `staff` SET `status` = 0 WHERE employee_id = ?";
              } else {
                $query = "UPDATE `staff` SET `status` = 1 WHERE employee_id = ?";
              }

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$employee_id]);
            $stmt = null;
        }

        public function getCurrentStatus($employee_id){
            $stmt1 = $this->dbh->prepare("SELECT `status` FROM `staff` WHERE employee_id = ?");
            $stmt1->execute([$employee_id]);
            $status = $stmt1->fetch(PDO::FETCH_ASSOC);
            $stmt1 = null;

            return $status['status'];
        }
    }