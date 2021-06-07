<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
 include 'employee.class.php';


 $array = Employee::getAllEmployees();
 foreach($array as $row) {
     echo $row['name'];
 }

 ?> 
 </body>
</html>