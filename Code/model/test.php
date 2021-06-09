<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include 'appointment.class.php';
 $array = (new Appointment(Database::get_connection()))->getNextAppointment("2");

echo $array['a_id'];

 ?> 
 </body>
</html>