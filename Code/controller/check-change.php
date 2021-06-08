<?php
require_once("../model/db_conn.php");
require_once("../model/user.class.php");


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $dbh = Database::get_connection();
    $user =(new Users($dbh))->verifyLogin($username, $password);
