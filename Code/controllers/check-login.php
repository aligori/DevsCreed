<?php
include "../db_conn.php";


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

$username = test_input($_POST['username']);
$password = test_input($_POST['password']);

//Hash the password
//$password = md5($password); //Use different hashing algorithm

$sql="SELECT * FROM `user_account` WHERE username='$username' AND password='$password'";
$result=mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    session_start();
    $record = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $record['user_id'];
    $_SESSION['username'] = $record['username'];
    $_SESSION['role'] = $record['role'];

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
