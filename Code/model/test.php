<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
  session_start();
  require_once ('db_conn.php');
 include_once('user.class.php');
print(password_hash("clinic123", PASSWORD_DEFAULT))
 ?> 
 </body>
</html>