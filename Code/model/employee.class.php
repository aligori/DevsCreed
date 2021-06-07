<?php
    require_once('db_conn.php');

    class Employee {

        private $dbh = null;

        public function __construct(){
            $this->dbh = (new Database())->get_connection();
        }

        public function getAllEmployees() {
            
            //Prepare query and fetch result

            $stmt = $this->dbh->prepare("SELECT * FROM `staff`");
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
        public function getEmployee($employee_id) {

            //Prepare query and fetch result

            $stmt = $this->dbh->prepare("SELECT * FROM `staff` WHERE `employee_id` = ?");
            $stmt->execute($employee_id);
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