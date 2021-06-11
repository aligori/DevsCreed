<?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
        include('model/db_conn.php');
        include('model/appointment.class.php');
        include('model/employee.class.php');

        $dbh = Database::get_connection();
        $requests = (new Appointment($dbh))->getAppointmentRequests();
        $doctors = (new Employee($dbh))->getDoctors();
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
                        <li class="breadcrumb-item"><a href="receptionist-appointments.php">Appointments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Requests</li>
                    </ol>
                </nav>
                <br/>
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_GET['error']?></div>
                <?php } else if (isset($_GET['success'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_GET['success']?></div>
                <?php } ?>

                <div class="card" style="margin-top: auto">
                    <div class="card-header">
                        <div class = "row">
                            <div class = "col-sm-9" >Requested Appointments </div>
                            <div class = "col-sm-3"  align="right">
                                <a> <i class="fas fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" >
                            <table id="today_table" class="table table-primary table-hover" >
                                <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Requested time</th>
                                    <th>Description</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($requests[1] == 0) { ?>
                                        <tr>
                                       <td colspan="6"> <h6 class="text-secondary">There are no requests</h6> </td>
                                    </tr>
                                    <?php } else {
                                        foreach($requests[0] as $request) { ?>
                                            <tr>
                                                <td id="a_id" hidden> <?php echo $request['a_id'] ?> </td>
                                                <td id="full_name"> <?php echo $request['full_name'] ?> </td>
                                                <td id="email"> <?php echo $request['email'] ?> </td>
                                                <td id="phone"> <?php echo $request['phone'] ?> </td>
                                                <td > <?php echo $request['time'] ?> </td>
                                                <td id="description"> <?php echo ($request['description'])?: "Not available" ?> </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm" value="" id="approve" data-toggle="modal" data-target="#approveModal">
                                                            <i class='fas fa-check'></i>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-sm" value="" id="reschedule" data-toggle="modal" data-target="#rescheduleModal">
                                                            <i class='fas fa-clock'></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" value="" id="reject">
                                                            <i class='fas fa-times'></i>
                                                        </button>
                                                    </td>
                                            </tr>
                                        <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Cancel Modal -->
                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Rejection Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to reject this appointment request?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form method="POST" action="controller/manage-requests.php">
                                    <input type="text" hidden id="cancel_a_id" name="cancel_a_id">
                                    <button type="submit" class="btn btn-danger" id="modal_reject_button" name="modal_reject_button">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approve Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="controller/manage-requests.php" class="border shadow p-3 rounded">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Available Doctors</label>
                                        <select class="form-control form-select form-select-lg mb-3" id="doctor_id" name="doctor_id">
                                            <?php
                                            foreach ($doctors as $doctor) {
                                                $employee_id = $doctor['employee_id'];
                                                echo '<option value="'.$employee_id.'">'.$doctor['full_name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="text" hidden id="approve_a_id" name="approve_a_id">
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="modal_approve_button" name="modal_approve_button">Confirm</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Reschedule Modal -->
                <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reschedule Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="controller/manage-requests.php" class="border shadow p-3 rounded" id="reschedule_form">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Doctor</label>
                                            <select class="form-control form-select form-select-lg mb-3" id="doctor_r" name="doctor_id">
                                                <option value="0">Select Doctor</option>
                                                <?php
                                                foreach ($doctors as $doctor) {
                                                    $employee_id = $doctor['employee_id'];
                                                    echo '<option value="'.$employee_id.'">'.$doctor['full_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="date">Date</label>
                                            <input type="date" name="date_r" class="form-control" id="date_r" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="time">Time</label>
                                            <select id="time" name="time" class="form-control">
                                                <option selected>Choose ...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success">Reschedule</button>
                                    </div>
                                </form>
                            </div>
                        </div>
            </main>
        </div>

    <script>
        $(document).ready( function() {

            $('#reject').on('click', function() {
                $('#cancelModal').modal('show');
                $tr = $(this).closest('tr');

                const data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#cancel_a_id').val(data[0]);
            })

            $('#approve').on('click', function() {
                $('#approveModal').modal('show');
                $tr = $(this).closest('tr');

                const data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#approve_a_id').val(data[0]);
            })

            $('#doctor_r, #date_r').on('change', function() {

                if(  $('#doctor_r option:selected').text() !== 'Select Doctor' && $('#date_r').val() ){
                    // make request for available dates only when both filled
                    const doctor_id = document.getElementById('doctor_r').value;
                    const date = $('#date_r').val();
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
        });
    </script>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>