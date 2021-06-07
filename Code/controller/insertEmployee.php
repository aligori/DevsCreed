<?php
    include('../model/employee.class.php');
    include('../model/user.class.php');

    $emp = new Employee();
    $full_name = $_POST["name"].' '.$_POST["surname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $birthday = $_POST["birthday"];
    if(isset($_POST["operation"])) {
        if($_POST["operation"] == "Add") {
            $salary = 35000;
            $status = 1; //TODO Change to 'active' later
            $user_id = NULL;
//            if ($_POST["create_user"]) {
//                //TODO Change role when db table is refactored
//                $user_id = (new Users())->createUser($_POST["name"], $_POST["surname"], 'doctor');
//            }
            $emp->registerEmployee($full_name, $email, $phone, $birthday, $salary, $status, $user_id);
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
    }