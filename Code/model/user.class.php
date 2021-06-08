<?php
    class Users {

        private $dbh;

        public function __construct($dbh){
            $this->dbh = $dbh;
        }

        public function verifyLogin($username, $password) {

            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `user_account` WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            return ($user && password_verify($password, $user['password'])) ? $user: null;
        }

        public function getUserbyId($id) {
            $query = "SELECT * FROM `user_account` WHERE id = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function createUser($name, $surname, $role) {
            $username =strtolower($name.$surname) ;
            $default_pass = 'clinic123';
            $hashed_default_pass = password_hash($default_pass, PASSWORD_DEFAULT);

            $query = "INSERT INTO `user_account` (`username`, `password`, `name`, `surname`, `role`) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$username, $hashed_default_pass, $name, $surname, $role]);
            return $this->dbh->lastInsertId();
        }

        public function getAllUsers() {

            //Prepare query and fetch result
            $stmt = $this->dbh->prepare("SELECT * FROM `user_account`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllUserAccounts($query): array {

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
    }
