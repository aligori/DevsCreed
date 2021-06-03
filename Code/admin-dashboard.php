<?php
    session_start();
    include "db_conn.php";
    if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && $_SESSION['role'] === 'admin') {
?>

<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
        <link href='assets/css/style.css' rel='stylesheet'>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <title>Admin Dashboard</title>
    </head>
    <body>
        <a href="logout.php" class="btn btn-primary">Log Out</a>
    </body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>