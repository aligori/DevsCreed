<?php
require_once("../model/db_conn.php");
require("../model/user.class.php");


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $username = $_SESSION['user']['username'];
    $user_id = $_SESSION['user_id'];
    $password = test_input($_POST['old_password']);
    $new_password = test_input($_POST['new_password']);
    $confirmed = test_input($_POST['confirmed_pass']);
    $dbh = Database::get_connection();
    $userClass = new Users($dbh);
    $user = ($userClass)->verifyLogin($username, $password);

    if ($user) {
        // Change password
        if($confirmed == $new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
//            var_dump($password, $new_password, $confirmed, $hashed_password, $user_id);
//            die();
            $userClass->changePassword($hashed_password, $user_id);
            header("Location: ../change_password.php?success=Password Changed Successfully");
        } else {
            header("Location: ../change_password.php?error=Passwords do not match");
        }
    } else {
        header("Location: ../change_password.php?error=Old password is not correct");
    }
}
