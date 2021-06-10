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
 $app = (new Appointment($dbh))->getNextAppointment( $employee['employee_id']);
 var_dump($app);
 die();

 ?> 
 </body>
</html>