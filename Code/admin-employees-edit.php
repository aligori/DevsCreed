<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    ?>

    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Required Scripts and Stylesheets   -->
        <?php include('shared-components/includes.php')?>
        <title>Admin Dashboard</title>
    </head>
    <body>
    <?php
    include('shared-components/admin/sidebar1.php');
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
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin-employees.php">Employees</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit employee</li>
                </ol>
            </nav>
            <br/>
                <div class="card-body">

                    <!--  Employee Modify-->
                    <div class="container" >
                        <div id="editEmployee">
                            <div class="modal-dialog">
                                <form method="POST" id="employee_form" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Employee</h4>
                                            <button type="button" class="close" onclick="location.href='admin-employees.php';">&times</button>
                                        </div>

                                        <?php
                                            include('./model/db_conn.php');
                                            include('./model/employee.class.php');
                                            $dbh = Database::get_connection();
                                            $userClass = new Employee($dbh);

                                            $employee_id = (int)$_GET['a'];
                                            $user = ($userClass)->getEmployee($employee_id);
                                            $data = $user;
                                            $pieces = explode(" ", $data['full_name']);

                                            $date = explode("-", $data['birthday']);
                                            $birthday = $date[2]."/".$date[1]."/".$date[0]
                                        ?>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Name</label>
                                                    <input
                                                            type="text"
                                                            name="name"
                                                            id="name"
                                                            class="form-control"
                                                            placeholder=<?php echo($pieces['0']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Surname</label>
                                                    <input
                                                            type="text"
                                                            name="surname"
                                                            id="surname"
                                                            class="form-control"
                                                            placeholder=<?php echo($pieces['1']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Email</label>
                                                    <input
                                                            type="email"
                                                            name="email"
                                                            id="email"
                                                            class="form-control"
                                                            placeholder=<?php echo($data['email']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Address</label>
                                                    <input
                                                            type="text"
                                                            name="address"
                                                            id="address"
                                                            class="form-control"
                                                            placeholder=<?php echo($data['address']); ?>
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
                                                            placeholder=<?php echo("0".$data['phone']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Birthdate</label>
                                                    <input
                                                            type="date"
                                                            name="birthday"
                                                            id="birthday"
                                                            class="form-control"
                                                            placeholder=<?php echo($birthday);  ?>
                                                            required
                                                    /><br/>
                                                    <label>Position</label>
                                                    <select class="form-control form-select form-select-lg mb-3" id="position">
                                                        <option value="" disabled selected hidden><?php echo($data['position']);?></option>
                                                        <option value="1">Doctor</option>
                                                        <option value="2">Receptionist</option>
                                                        <option value="3">Economist</option>
                                                        <option value="3">Janitor</option>
                                                    </select><br/><br/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="employee_id" id="employee_id"/>
                                            <input type="hidden" name="operation"/>
                                            <input type="submit" name="action" id="action" class="btn btn-primary" value="Edit"/>
                                            <button type="button" class="btn btn-danger" onclick="location.href='admin-employees.php';"> Cancel</button>
                                        </div>
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

            $('#editEmployee').click(function(){
                // $('#employee_form')[0].reset();
                $('#action').val("Edit");
                $('#operation').val("Edit");
            });

            $('#employee_form').on('submit', function(event) {

                event.preventDefault();

                const data = {
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    birthday: $('#birthday').val(),
                    address: $('#address').val(),
                    position: $('#position option:selected').text(),
                    operation: $('#action').val()
                };

                console.log(data);

                $.ajax({
                    url: "controller/editEmployee.php",
                    method: "POST",
                    dataType: "json",
                    data: data,
                    // contentType: false,
                    // processData: false,
                    success: function(data) {
                        location.href='admin-employees.php';
                    }
                });
            });
        })
    </script>
    </body>
    </html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>