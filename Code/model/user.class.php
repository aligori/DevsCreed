<?php
    require_once('../db_conn.php');

    class Users {

        public static function verifyLogin($username, $password) {
            //Get DB connection
            $dbh = (new Database())->get_connection();
            //Prepare query and fetch result
            $stmt = $dbh->prepare("SELECT * FROM `user_account` WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            return ($user && password_verify($password, $user['password'])) ? $user: null;
        }
    }