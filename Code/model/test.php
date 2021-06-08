<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
 include 'employee.class.php';

 $array = (new Employee())->registerEmployee('Sam Smith', 'anie@gmail.com','34543334','2000-10-10',300000,1,NULL);
echo $array

 ?> 
 </body>
</html>