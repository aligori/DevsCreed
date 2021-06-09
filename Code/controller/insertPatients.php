<?php
include_once('../model/patient.class.php');
include_once('../model/user.class.php');
include_once('../model/db_conn.php');

$dbh = Database::get_connection();
$pt = new Patient($dbh);
$full_name = $_POST["name"].' '.$_POST["surname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$address = $_POST["address"];

if(isset($_POST["operation"])) {
    if($_POST["operation"] == "Add") {
        $status = "active";
        $user_id = (new Users($dbh))->createUser($_POST["name"], $_POST["surname"], "patient");
        $result = $pt->registerPatient($full_name, $email, $phone, $birthday, $address, $status, $user_id);
        if ($result) {
            echo json_encode(array("statusCode"=>200));
        }
    }
    if($_POST["operation"] == "Edit") {
        $full_name = $_POST["name"].' '.$_POST["surname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $birthday = $_POST["birthday"];
        //Change salary
        //Change status
        //TODO General Update function
    }
} else {
    echo "No action available";
}