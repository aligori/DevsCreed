<?php
    require_once('../db_conn.php');

    class Users {
        public static function verifyLogin($username, $password) {
            $dbh = (new Database())->get_connection();
            //Prepare query and fetch result
            $stmt = $dbh->prepare("SELECT * FROM `user_account` WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            return ($user && password_verify($password, $user['password'])) ? $user: null;
        }

        public static function getUserbyId($id) {
            $dbh = (new Database())->get_connection();
            $query = "SELECT * FROM `user_account` WHERE id = ?";
            $stmt = $dbh->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public static function createUser($name, $surname, $role) {
            $dbh = (new Database())->get_connection();
            $username = $name.$surname;
            $default_pass = 'clinic123';
            $hashed_default_pass = password_hash($default_pass, PASSWORD_DEFAULT);

            $query = "INSERT INTO `user_account` (`password`, `username`, `name`, `surname`, `role`) VALUES (?, ?, ?, ?, ?);";
            $stmt = $dbh->prepare($query);
            $stmt->execute([$username, $hashed_default_pass, $name, $surname, $role]);
        }

        public static function getAllUsers() {

            //Prepare query and fetch result
            $dbh = (new Database())->get_connection();
            $stmt = $dbh->prepare("SELECT * FROM `user_account`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
