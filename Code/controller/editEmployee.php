<?php
    include_once('../model/employee.class.php');
    include_once('../model/user.class.php');
    include_once('../model/db_conn.php');

var_dump($_POST);
die();

    $dbh = Database::get_connection();
    $emp = new Employee($dbh);
    $full_name = $_POST["name"].' '.$_POST["surname"];
    $email = $_POST["email"];
    $status = strtolower($_POST["status"]);

    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $salary = intval($_POST["salary"]);
    $position = strtolower($_POST["position"]);

    $employee_id = intval($_POST["employee_id"]);

    if(isset($_POST["operation"])) {

        if ($_POST["operation"] == "Edit") {
            $result = $emp->updateEmployee($employee_id, $full_name, $email, $position, $address, $phone, $status, $salary);
            if ($result) {
                echo json_encode(array("statusCode" => 200));
            }
        }
    } else {
        echo "No action available";
    }