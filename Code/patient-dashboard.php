<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'patient') {
    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>-->
    <?php include('shared-components/includes.php') ?>
    <title>Patient Dashboard</title>
</head>
<body>
<?php
include('shared-components/patient/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>

        <nav aria-label="breadcrumb" style="margin-top: 60px;">
            <ol class="breadcrumb">
                <h4 class="text-secondary">
                    Hello, <?php echo $_SESSION['user']['name'];  echo $_SESSION['user']['surname'] ?>
                </h4>
            </ol>
        </nav>

        <div class="dash-cards">
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-time"></span>
                    <div>
                        <h5>Next Appointment</h5>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="admin-employees.php">View</a>
                </div>
            </div>

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-support"></span>
                    <div>
                        <h5>Book Appointment</h5>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="">Book</a>
                </div>
            </div>

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-reload"></span>
                    <div>
                        <h5>Previous Appointments</h5>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="">View all</a>
                </div>
            </div>
        </div>
        <br/>

    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>