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
            $stmt->execute([$employee_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateEmployee($employee_id, $full_name, $email, $position, $address, $phone, $status, $salary) {
            $query = "UPDATE `staff` 
                    SET `full_name` = ?, 
                   `email`= ?, 
                   `position` = ?,
                   `address` = ?, 
                   `phone` = ?, 
                   `status` = ?, 
                   `salary` = ?
                    WHERE `employee_id` = ?;";

            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$full_name, $email, $position, $address, $phone, $status, $salary, $employee_id]);
            $stmt = null;
        }

        public function getDoctors(){
            $query = "SELECT * FROM `staff` WHERE `position` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute(["doctor"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }