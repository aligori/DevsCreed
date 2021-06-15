<?php
    session_start();
    if(!isset($_SESSION['user_id'])) {
        ?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/theme.css" rel="stylesheet">
    <title>Log in</title>
</head>
<body style="background: url('assets/images/image1.jpg') no-repeat;">

<?php include('./shared-components/header.php') ?>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <form class="border shadow p-3 rounded"
              action="controller/check-login.php"
              method="post"
              style="width: 35%">
            <h1 class="text-center p-3" style="letter-spacing: 3px; font-weight: bolder">Log in</h1>
            <h6 style="text-align: center;font-weight: 10; font-size: 13px;letter-spacing: 2px">
                with the username provided <br> by the clinic to access the system
            </h6>
                <hr style="width: 100%; top: 30%; border-color:#5599FF">
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert"><?=$_GET['error']?></div>
            <?php } ?>
            <div class="mb-3">
                <label for="username"
                       class="form-label">Username</label>
                <input type="text"
                       class="form-control"
                       name="username"
                       id="username"
                       placeholder="Enter your username"
                       required>
            </div>
            <div class="mb-3">
                <label for="password"
                       class="form-label">Password</label>
                <i class="bi bi-password"></i>
                <input type="password"
                       class="form-control"
                       name="password"
                       id="password"
                       placeholder="Enter your password"
                       required>
            </div>
            <p align="center">
                <button type="submit" class="btn btn-secondary justify-content-left">Submit</button>
            </p>
        </form>
    </div>

<?php include('./shared-components/footer.php') ?>

<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>
<?php } else {
        if ($_SESSION['role'] == 'admin')
            header("Location: admin-dashboard.php");
        else if ($_SESSION['role'] == 'doctor')
            header("Location: doctor-dashboard.php");
        else if ($_SESSION['role'] == 'receptionist')
            header("Location: receptionist-dashboard.php");
        else if ($_SESSION['role'] == 'patient')
            header("Location: patient-dashboard.php");
        else if ($_SESSION['role'] == 'economist')
            header("Location: economist-dashboard.php");
    } ?>