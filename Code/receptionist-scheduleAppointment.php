<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    include_once ('model/db_conn.php');
    include_once('model/employee.class.php');
    $dbh = Database::get_connection();
//    (new Employee($dbh))->getDoctors();
    $doctors = array("Armela Ligori", "Kim Tan");
    ?>

    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Required Scripts and Stylesheets   -->
        <?php include('shared-components/includes.php')?>
        <title>Receptionist Dashboard</title>
    </head>
    <body>
    <?php
    include('shared-components/receptionist/sidebar.php');
    ?>
    <div class="main-content">
        <!--    Topbar       -->
        <header>
            <div class="navbar navbar-dark">
                <a href="admin-dashboard.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
                <a><?php echo $_SESSION['user']['username'] ?></a>
            </div>
        </header>

        <main>
            <br/>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="receptionist-dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="receptionist-appointments.php">Appointments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Schedule Appointment</li>
                </ol>
            </nav>
            <br/>
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <form class="border shadow p-3 rounded">
                            <h4>Appointment's Details</h4>
                            <hr/>
                            <div class="form-row" >
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="password" class="form-control" id="name" placeholder="Password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Service</label>
                                <select class="form-control form-select form-select-lg mb-3" id="service">
                                    <option value="1">General</option>
                                    <option value="2">Eye Strain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <select class="form-control form-select form-select-lg mb-3" id="doctor">
<!--                                        --><?php
//                                        foreach ($doctors as $doctor) {
//                                            $employee_id = $doctor;
//                                            ?><!-- <option value="--><?php //echo $doctor['employee_id'] ?><!--">--><?// echo $doctor['full_name'] ?><!--</option>' --><?php
//                                        }
//                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="time">Time</label>
                                    <select id="time" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <input type="submit" name="action" id="action" class="btn btn-primary" value="Add"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> Clear </button>
                        </form>
                    </div>
                    <div class="col-2"></div>
                </div>
        </main>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){

            $('#appointment_form').on('submit', function(event) {
                event.preventDefault();

                const data = {
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    birthday: $('#birthday').val(),
                    address: $('#address').val(),
                    operation: $('#action').val()
                };

                console.log(data);

                $.ajax({
                    url: "controller/insertPatients.php",
                    method: "POST",
                    dataType: "json",
                    data: data,
                    // contentType: false,
                    // processData: false,
                    success: function(data) {
                        console.log(data);
                        $('#patient_form')[0].reset();
                        $('#addPatient').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            });

            $('#position').on('change', function () {
                console.log('test')
            })
        })
    </script>
    </body>
    </html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>