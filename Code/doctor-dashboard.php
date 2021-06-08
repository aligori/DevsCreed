<?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'doctor') {
?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <?php include('shared-components/includes.php') ?>
    <title>Doctor Dashboard</title>
</head>
<body>
<?php
include('shared-components/doctor/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <nav aria-label="breadcrumb" style="margin-top: 30px;">
            <ol class="breadcrumb">
                <h5 class="text-secondary">
                    Hello, <?php echo $_SESSION['user']['name']." ";  echo $_SESSION['user']['surname'] ?>
                </h5>
            </ol>
        </nav>
        <div class="dash-cards">
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-wheelchair"></span>
                    <div>
                        <h5>Active Patients</h5>
                        <h4>Get from database</h4>
                        <br/>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="doctor-patients.php" class="btn btn-outline-primary">View All <span class="ti-angle-right"> </span></a>
                </div>
            </div>
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-write"></span>
                    <div>
                        <h5>New Health Record</h5>
                        <h4>Get from database</h4>
                        <br/>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="doctor-patients.php" class="btn btn-outline-primary">Create <span class="ti-plus"> </span></a>
                </div>
            </div>
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-alarm-clock"></span>
                    <div>
<!--                        FIX THIS WITH PHP QUERY-->
                        <h5>Next Appointment</h5>
                        <h4>Armela Ligori</h4>
                        <h4>15:15</h4>
                    </div>
                </div>
                <div class="card-footer ">
                    <a href="doctor-patients.php" class="btn btn-outline-primary">View  <span class="ti-angle-right"> </span></a>
                </div>
            </div>
        </div>
        <br/>
        <div class="card" style="margin-top: auto">
            <div class="card-header">
                <div class = "row">
                    <div class = "col-sm-9" >Your schedule for today </div>
                    <div class = "col-sm-3"  align="right">
                        <a> <i class="fas fa-print"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!--  Employee Table-->
                <div class="table-responsive" >
                    <table id="today_table" class="display table table-primary" >
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Visit time</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!--<script>-->
<!--    // Basic example-->
<!--    $(document).ready(function () {-->
<!--        $('#today_table').DataTable({-->
<!--            "pagingType": "simple" // "simple" option for 'Previous' and 'Next' buttons only-->
<!--        });-->
<!--        $('.dataTables_length').addClass('bs-select');-->
<!--    });-->
<!--</script>-->
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>