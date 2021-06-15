<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    ?>
    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Receptionist Dashboard</title>
</head>
<body>
<?php
include('shared-components/receptionist/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="receptionist-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Doctors</li>
            </ol>
        </nav>
        <br/>
        <br/>
        <div class="card" style="margin-top: auto">
            <div class="card-header">
                <div class = "row">
                    <div class = "col-sm-9" >Upcoming Appointments </div>
                    <div class = "col-sm-3"  align="right">
                        <a> <i class="fas fa-print"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>