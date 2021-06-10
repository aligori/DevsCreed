<?php
    include_once('../model/employee.class.php');
    include_once('../model/db_conn.php');

    session_start();

    if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
        $dbh = Database::get_connection();
        $query = '';
        $output = array();
        $query .= 'SELECT * FROM `staff`';

        // Prepare query statement
        if(isset($_POST['search']['value'])) {
            $query .= 'WHERE full_name LIKE "%'.$_POST["search"]["value"].'%"';
            $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%"';
            $query .= 'OR phone LIKE "%'.$_POST["search"]["value"].'%"';
            $query .= 'OR position LIKE "%'.$_POST["search"]["value"].'%"';
        }

        if(isset($_POST['order'])) {
            $query .= 'ORDER BY'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].'';
        } else {
            $query .= 'ORDER BY employee_id ASC ';
        }

        $emp = new Employee($dbh);
        $result = $emp->getAllEmployees($query);
        $data = $result[0];
        $filtered_rows = $result[1];
        $table = "";

        foreach($data as $row) {

            $edit = '<a href=\"admin-employees-edit.php?a='.$row['employee_id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\">Edit</a>';
            $table.='{
                      "employee_id":"'.$row['employee_id'].'",
                      "full_name":"'.$row['full_name'].'",
                      "position":"'.$row['position'].'",
                      "email":"'.$row['email'].'",
                      "phone":"'.$row['phone'].'",
                      "birthday":"'.$row['birthday'].'",
                      "salary":"'.$row['salary'].'",
                      "address":"'.$row['address'].'",
                      "status":"'.$row['status'].'",
                      "edit": "'.$edit.'"
                    },';
        }
        $table = substr($table,0, strlen($table) - 1);
        echo '{"data":['.$table.']}';
    } else {
        header("Location: ../login.php?error=Access Forbidden");
    }
