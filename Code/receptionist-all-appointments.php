<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    require_once ('model/db_conn.php');
    include 'model/appointment.class.php';
    include 'model/user.class.php';

    $dbh = Database::get_connection();
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    $app_class = new Appointment($dbh);
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
include('shared-components/receptionist/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="receptionist-dashboard.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="receptionist-dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="receptionist-appointments.php">Appointments</a></li>
                <li class="breadcrumb-item active" aria-current="page">All</li>
            </ol>
        </nav>
        <br/>
        <a href="receptionist-scheduleAppointment.php"><button class="btn btn-primary" id="today">New Appointment</button></a>
        <br/>
        <br/>

        <table id="appointments_table" class="table table-primary" >
            <thead>
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Visit time</th>
                <th>Doctor</th>
                <th>Status</th>
                <th>Service</th>
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
                url:"controller/view-appointments.php",
                type:"POST"
            },
            "columns": [
                {"data": "full_name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "time"},
                {"data": "doctor"},
                {"data": "status"},
                {"data": "service"}
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