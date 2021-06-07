<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
 include 'employee.class.php';

 $array = (new Employee())->getAllEmployees();
 foreach($array as $row) {
     echo $row['full_name'];
 }

 ?> 
 </body>
</html>