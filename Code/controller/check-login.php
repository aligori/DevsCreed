<?php
require_once("../model/user.class.php");


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $user = Users::verifyLogin($username, $password);

    if ($user) {
        session_start();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $user['role'];

        if($_SESSION['role'] == 'admin')
            header("Location: ../admin-dashboard.php");
        else if ($_SESSION['role'] == 'doctor')
            header("Location: ../doctor-dashboard.php");
        else if ($_SESSION['role'] == 'receptionist')
            header("Location: ../receptionist-dashboard.php");
        else if ($_SESSION['role'] == 'patient')
            header("Location: ../patient.php");
        else if ($_SESSION['role'] == 'economist')
            header("Location: ../economist.php");
    } else {
        header("Location: ../login.php?error=Incorrect credentials");
    }
}
