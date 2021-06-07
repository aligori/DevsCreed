<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
 include 'employee.class.php';

 echo (new Employee())->getEmployee(1);
 echo "<br>";
 echo (new Employee())->changeStatus(1);
 echo "<br>";
 echo (new Employee())->getEmployee(1);

 ?> 
 </body>
</html>