<?php

use Mpdf\Mpdf;
require('../assets/vendor/autoload.php');
include_once('../model/db_conn.php');
include_once('../model/appointment.class.php');

session_start();

if($_SESSION['role'] == 'doctor' || $_SESSION['role'] == 'receptionist') {
    $dbh = Database::get_connection();

    $doctor_id = $_GET['doctor_id'];
    $rows = (new Appointment($dbh))->getTodaysSchedule($doctor_id);

    $html='<div class="row"><h3>Your schedule for today</h3></div><table class="table">';
    $html.= '<tr><td><h5>Full Name</h5></td><td><h5>Email</h5></td><td><h5>Time</h5></td><td><h5>Phone</h5></td><td><h5>Status</h5></td></tr>';
    foreach($rows as $row){
        $html.='<tr><td>'.$row['full_name'].'</td><td>'.$row['email'].'</td><td>'.$row['time'].'</td><td>'.$row['phone'].'</td><td>'.$row['status'].'</td></tr>';
    }
    $html.='</table></div>';

    $mpdf=new Mpdf();
    $mpdf->WriteHTML($html);
    $file='media/'.time().'.pdf';
    $mpdf->output($file,'I');
}