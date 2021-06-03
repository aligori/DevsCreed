<?php
$hostname="localhost";
$username="root";
$password="";
$db_name="eye_clinic";

$conn=mysqli_connect($hostname, $username, $password, $db_name);

if (!$conn) {
    echo "Connection Failed!";
    exit();
}