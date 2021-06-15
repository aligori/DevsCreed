<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'doctor') {
    require_once ('model/db_conn.php');
    include 'model/appointment.class.php';
    include 'model/user.class.php';

    $dbh = Database::get_connection();
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    $app_class = new Appointment($dbh);
    $today_schedule = ($app_class)->getTodaysSchedule($employee["employee_id"])
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
            <a href="doctor-dashboard.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Schedule</li>
            </ol>
        </nav>
        <br/>
        <button class="btn btn-outline-primary" id="today">Today</button>
        <button class="btn btn-outline-success" id="tomorrow">Tomorrow</button>
        <br/>
        <br/>

        <table id="appointments_table" class="table table-primary" >
            <thead>
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Visit time</th>
                <th>Status</th>
                <th>Service</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </main>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('#appointments_table').DataTable({
            responsive: true,
            "bDeferRender":true,
            "sPaginationType": "full_numbers",
            "ajax":{
                url:"controller/viewSchedule.php",
                type:"POST"
            },
            "columns": [
                {"data": "full_name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "time"},
                {"data": "status"},
                {"data": "service"},
                {"data": "action"}
            ],
            "oLanguage": {
                "sProcessing": "Processing...",
            }
        })
    } );
</script>

</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>