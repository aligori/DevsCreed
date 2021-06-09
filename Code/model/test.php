<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include 'appointment.class.php';
 $array = (new Appointment(Database::get_connection()))->getAvailableTimeSlots("2021-06-09", "2");

foreach($array as $i) {
    echo $i." ";
}

 ?> 
 </body>
</html>