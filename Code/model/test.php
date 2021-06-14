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
 $employee = (new Employee($dbh))->updateEmployee(13, "Oltjon Rabeli", "orabeli@gmail.com", "economist", "Durres", "0696822989", "active", 5000);


 ?> 
 </body>
</html>