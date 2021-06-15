<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    include_once ('model/db_conn.php');
    include_once('model/employee.class.php');
    include_once('model/service.class.php');

    $dbh = Database::get_connection();
    $doctors = (new Employee($dbh))->getDoctors();
    $services = (new Service($dbh))->getServices();
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
                        <form method="POST" action="controller/book-appointment.php" class="border shadow p-3 rounded" id="appointment_form">
                            <h4>Appointment's Details</h4>
                            <?php if (isset($_GET['success'])) { ?>
                                <div class="alert alert-success" role="alert"><?=$_GET['success']?></div>
                            <?php } ?>
                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger" role="alert"><?=$_GET['error']?></div>
                            <?php } ?>
                            <hr/>
                            <div class="form-row" >
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Service</label>
                                    <select class="form-control form-select form-select-lg" id="service" name="service_id">
                                        <?php
                                            foreach ($services as $service) {
                                                $service_id = $service['service_id'];
                                                echo '<option value="'.$service_id.'">'.$service['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <select class="form-control form-select form-select-lg mb-3" id="doctor" name="doctor_id">
                                        <option value="0">Select Doctor</option>
                                        <?php
                                        foreach ($doctors as $doctor) {
                                            $employee_id = $doctor['employee_id'];
                                            echo '<option value="'.$employee_id.'">'.$doctor['full_name'].'</option>';
                                        }
//                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" class="form-control" id="date" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="time">Time</label>
                                    <select id="time" name="time" class="form-control">
                                        <option selected>Choose ...</option>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label for="desc">Optional Details</label>
                                <textarea class="form-control" id="desc" name="desc" rows="2"></textarea>
                            </div>
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

            // $('#appointment_form').on('submit', function(event) {
            //     event.preventDefault();
            //
            //     const data = {
            //         full_name: $('#name').val(),
            //         email: $('#email').val(),
            //         service_id: document.getElementById('service').value,
            //         doctor_id: document.getElementById('doctor').value,
            //         date: $('#date').val(),
            //         time: document.getElementById('time').value,
            //     };
            //
            //     console.log(data);
            //
            //     $.ajax({
            //         url: "controller/book-appointment.php",
            //         method: "POST",
            //         dataType: "json",
            //         data: data,
            //         success: function(data) {
            //             alert(data);
            //         }
            //     });
            // });

            $('#doctor, #date').on('change', function() {

                if(  $('#doctor option:selected').text() !== 'Select Doctor' && $('#date').val() ){
                    // make request for available dates only when both filled
                    console.log('Both completed');
                    const doctor_id = document.getElementById('doctor').value;
                    const date = $('#date').val();
                    $('#time').children().remove().end();

                    $.ajax({
                        type: "GET",
                        url: 'controller/available-timeslots.php',
                        data: {doctor_id: doctor_id, date: date},
                        success: function(data) {
                            const slots = JSON.parse(data);

                            // get reference to select element
                            const select = document.getElementById('time');
                            select.remove(0);

                            for (const [key, value] of Object.entries(slots)) {
                                const opt = document.createElement('option');
                                opt.appendChild(document.createTextNode(value + ':00:00'));
                                opt.value = value;
                                select.appendChild(opt);
                            }
                        }
                    });
                }
            });
        })
    </script>
    </body>
    </html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>