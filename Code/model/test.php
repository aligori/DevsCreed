<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include_once('employee.class.php');
 $dbh = Database::get_connection();
 $doctors = (new Employee($dbh))->getDoctors();
 var_dump($doctors);
 die();

 ?> 
 </body>
</html>