<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php

 include 'employee.class.php';

 echo (new Employee())->getEmployee(1);
 echo "<br>";
 echo (new Employee())->modifyEmployeeData(1, 'fullname', 'Denado Rabelii');
 echo "<br>";
 echo (new Employee())->getEmployee(1);

 ?> 
 </body>
</html>