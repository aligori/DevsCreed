<?php
session_start();
if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'receptionist' || $_SESSION['role'] === 'doctor' || $_SESSION['role'] === 'admin')) {
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

    if($_SESSION['role'] == 'receptionist') {
        include('shared-components/receptionist/sidebar.php');
    } else if ($_SESSION['role'] == 'doctor'){
        include('shared-components/doctor/sidebar.php');
    } else if (($_SESSION['role'] == 'admin')){
        include('shared-components/admin/sidebar1.php');
    }
    ?>
    <div class="main-content">
        <!--    Topbar       -->
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
                    <li class="breadcrumb-item active" aria-current="page">Patients</li>
                </ol>
            </nav>
            <br/>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert"><?=$_GET['error']?></div>
            <?php } ?>
            <div class="card" style="margin-top: auto">
                <div class="card-header">
                    <div class = "row">
                        <div class = "col-sm-9" >Patients </div>
                        <div class = "col-sm-3"  align="right">
                            <?php if($_SESSION['role'] == 'receptionist') {
                                ?>
                            <button type="submit"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#addPatient"
                            > <i class="fas fa-plus-circle"></i>
                                New Patient
                            </button>
                            <?php } else if($_SESSION['role'] == 'doctor') { ?>
                            <button type="button"
                                    class="btn btn-secondary"
                                    data-toggle="modal"
                                    data-target="#chooseModal"
                            > <i class="fas fa-book"></i>
                                 Health Records
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--  Patient Table-->
                    <div class="table-responsive" >
                        <table id="patient_table" class="display table table-primary" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Birthdate</th>
                                <th>Address</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Patient Modal-->
            <div id="addPatient" class="modal fade">
                <div class="modal-dialog">
                    <form method="POST" id="patient_form" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Patient</h4>
                                <button type="button" class="close" data-dismiss="modal">&times</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Name</label>
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter name"
                                            required
                                        /><br/>
                                        <label>Surname</label>
                                        <input
                                            type="text"
                                            name="surname"
                                            id="surname"
                                            class="form-control"
                                            placeholder="Enter surname"
                                            required
                                        /><br/>
                                        <label>Email</label>
                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="form-control"
                                            placeholder="Enter email"
                                            required
                                        /><br/>
                                    </div>
                                    <div class="col-6">
                                        <label>Phone</label>
                                        <input
                                            type="phone"
                                            name="phone"
                                            id="phone"
                                            class="form-control"
                                            placeholder="Enter phone number"
                                            required
                                        /><br/>
                                        <label>Birthdate</label>
                                        <input
                                            type="date"
                                            name="birthday"
                                            id="birthday"
                                            class="form-control"
                                            placeholder="Select birthdate"
                                            required
                                        /><br/>
                                        <label>Address</label>
                                        <input
                                                type="text"
                                                name="address"
                                                id="address"
                                                class="form-control"
                                                placeholder="Enter address"
                                                required
                                        /><br/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="patient_id" id="patient_id"/>
                                <input type="hidden" name="operation"/>
                                <input type="submit" name="action" id="action" class="btn btn-primary" value="Add"/>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--  Health records Modal -->
            <div class="modal fade" id="chooseModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Choose Patient</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="doctor-healthrecords.php" class="border shadow p-3 rounded">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Enter Patient ID</label>
                                        <input type="text" class="form-control mb-3" id="patient_id" name="patient_id" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="modal_approve_button" name="modal_approve_button">View</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){

            $('#addPatient').click(function(){
                // $('#employee_form')[0].reset();
                $('.modal-title').text("Add Patient Details");
                $('#action').val("Add");
                $('#operation').val("Add");
            });

            const dataTable = $('#patient_table').DataTable({
                "bDeferRender":true,
                "sPaginationType": "full_numbers",
                // "serverSide":true,
                "ajax":{
                    url:"controller/searchPatients.php",
                    type:"POST"
                },
                "columns": [
                    {"data": "patient_id"},
                    {"data": "full_name"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "birthday"},
                    {"data": "address"},
                    {"data": "edit"}
                ],
                "oLanguage": {
                    "sProcessing": "Processing...",
                }
            })

            $('#patient_form').on('submit', function(event) {
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