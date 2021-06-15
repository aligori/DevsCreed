<?php
session_start();
if($_SESSION['role'] == 'doctor') {
    include_once('model/db_conn.php');
    include_once('model/patient.class.php');
    $dbh = Database::get_connection();
    $patient_id = $_POST['patient_id'];
    $patient_obj = new Patient($dbh);
    $patient = ($patient_obj)->getPatientById($patient_id);
    $diagnosis = $patient_obj->getDiagnosis($patient_id);
    if ($patient) {
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
                        <li class="breadcrumb-item"><a href="receptionist-patients.php">Patients</a></li>
                        <li class="breadcrumb-item" aria-current="page"><?php echo $patient['full_name'] ?></li>
                    </ol>
                </nav>
                <br/>

                <form class="border shadow p-3 rounded">
                 <h4>Personal Details</h4>
                <div class="row">
                    <div class="col-3">
                        <img class="img-fluid" src="assets/images/default-profile.jpg"> <br/>
                    </div>
                    <div class="col-9">
                        <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> Patient ID No</span>
                                        <input type="text"
                                               class="form-control"
                                               aria-label="Sizing example input"
                                               aria-describedby="inputGroup-sizing-sm"
                                               value="<?php echo $patient['patient_id'] ?>"
                                        >
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Personal No.</span>
                                        <input type="text"
                                               class="form-control"
                                               aria-label="Sizing example input"
                                               aria-describedby="inputGroup-sizing-sm"
                                               value="<?php echo $patient['personal_no'] ?>"
                                        >
                                    </div>
                                        <input type="text" class="form-control mb-3" value="<?php echo $patient['full_name'] ?>" />
                                        <input type="text" class="form-control mb-3" value="<?php echo $patient['email'] ?>" />
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mb-3" value="<?php echo $patient['phone'] ?>" />
                                    <input type="text" class="form-control mb-3" value="<?php echo $patient['birthday'] ?>" />
                                    <input type="text" class="form-control mb-3" value="<?php echo $patient['address'] ?>" />
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"> Diagnosis </span>
                                        <input type="text"
                                               class="form-control"
                                               aria-label="Sizing example input"
                                               aria-describedby="inputGroup-sizing-sm"
                                               value="<?php echo $diagnosis['name'] ?>"
                                        />
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
                </form>
                <br/>
                <div class="card-body">
                    <div class="table-responsive" >
                        <table id="today_table" class="display table table-primary" >
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Visit time</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>

<!--                            --><?php //foreach($today_schedule as $app) { ?>
<!--                                <tr>-->
<!--                                    <td id="full_name"> --><?php //echo $app['full_name'] ?><!-- </td>-->
<!--                                    <td id="full_name"> --><?php //echo $app['email'] ?><!-- </td>-->
<!--                                    <td id="full_name"> --><?php //echo $app['phone'] ?><!-- </td>-->
<!--                                    <td id="full_name"> --><?php //echo explode(' ', $app['time'])[1] ?><!-- </td>-->
<!--                                    <td id="full_name"> --><?php //echo $app['status'] ?><!-- </td>-->
<!--                                    <form action="" method="post">-->
<!--                                        <td>-->
<!--                                            <button type="submit" class="btn btn-warning btn-sm" value="">  Cancel <i class='fas fa-times'></i> </button>-->
<!--                                        </td> </form>-->
<!--                                </tr>-->
<!--                            --><?php //} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        </body>
        </html>
<?php
    } else {
        header("Location: receptionist-patients.php?error=Please provide an existing ID.");
    }
} else {
        header("Location: login.php");
}
