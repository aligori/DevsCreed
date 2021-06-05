<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php 
 include 'employee.class.php';

 echo (new Employee())->getEmployee(1); 
 echo (new Employee())->modifyEmployeeData(1, "full_name", "Denado Rabelii"); 
 echo (new Employee())->getEmployee(1); 

 ?> 
 </body>
</html>