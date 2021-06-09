<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include 'user.class.php';

 $array = (new Users(Database::get_connection()))->getAllEmployeeData('2');
var_dump($array);
die();

 ?> 
 </body>
</html>