<?php
    include_once('../model/employee.class.php');
    include_once('../model/user.class.php');
    include_once('../model/db_conn.php');

    $dbh = Database::get_connection();
    $emp = new Employee($dbh);
    $full_name = $_POST["name"].' '.$_POST["surname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $position = strtolower($_POST["position"]);

    if(isset($_POST["operation"])) {
        if($_POST["operation"] == "Add") {
            $salary = 35000;
            $status = "active";
            $user_id = NULL;
            if ($_POST["createUser"]) {
                $user_id = (new Users($dbh))->createUser($_POST["name"], $_POST["surname"], $position);
            }
            $result = $emp->registerEmployee($full_name, $email, $position, $phone, $birthday, $salary, $address, $status, $user_id);
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