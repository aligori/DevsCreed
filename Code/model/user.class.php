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
            $query = "SELECT * FROM `user_account` WHERE user_id = ?";
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
            $stmt = null;
            return $result;
        }

        public function changePassword($newPassword, $user_id) {
            $query = "UPDATE `user_account` SET `password` = ? WHERE `user_id` = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$newPassword, $user_id]);
        }

        public function getAllEmployeeData($user_id) {
            $stmt = $this->dbh->prepare("SELECT employee_id FROM `user_account` INNER JOIN `staff` ON user_account.user_id = staff.user_id WHERE $user_id = ?");
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function setOnline($user_id) {
            $stmt = $this->dbh->prepare('UPDATE `user_account` set isOnline = "online" WHERE `user_id` = ?');
            return $stmt->execute([$user_id]);
        }

        public function setOffline($user_id) {
            $stmt = $this->dbh->prepare('UPDATE `user_account` set isOnline = "offline" WHERE `user_id` = ?');
            return $stmt->execute([$user_id]);

        }

        public function getNrOnline() {
            $stmt = $this->dbh->prepare("SELECT * FROM `user_account` where isOnline = 'online' and `role` not in ('patient')");
            $stmt->execute();
            $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->rowCount() - 1;
        }
    }
