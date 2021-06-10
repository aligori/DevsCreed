<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include_once('appointment.class.php');
 include_once('user.class.php');
 $dbh = Database::get_connection();
 $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
 $app = (new Appointment($dbh))->getDoctorsAppointments( "SELECT * FROM `appointment` as A INNER JOIN `service` as S on A.service_id = S.service_id WHERE doctor_id = ? ", 6);


 include_once('patient.class.php');
 $dbh = Database::get_connection();
 $nr_patients = (new Patient($dbh))->getNrPatients();


 $dbh = Database::get_connection();
 $requests = (new Appointment($dbh))->getAppointmentRequests();
 var_dump($requests);
 die();

 ?> 
 </body>
</html>