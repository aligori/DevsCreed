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

                                            $employee_id = intval($_GET['a']);
                                            $user = ($userClass)->getEmployee($employee_id);
                                            $pieces = explode(" ", $user['full_name']);
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
                                                            value=<?php echo($pieces['0']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Surname</label>
                                                    <input
                                                            type="text"
                                                            name="surname"
                                                            id="surname"
                                                            class="form-control"
                                                            value=<?php echo($pieces['1']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Email</label>
                                                    <input
                                                            type="email"
                                                            name="email"
                                                            id="email"
                                                            class="form-control"
                                                            value=<?php echo($user['email']); ?>
                                                            required
                                                    /><br/>

                                                    <label>Status</label>
                                                    <select class="form-control form-select form-select-lg mb-3" id="status">
                                                        <option value="" selected hidden><?php echo($user['status']);?></option>
                                                        <option value="1">Active</option>
                                                        <option value="2">Passive</option>
                                                    </select>

                                                </div>
                                                <div class="col-6">
                                                    <label>Phone</label>
                                                    <input
                                                            type="phone"
                                                            name="phone"
                                                            id="phone"
                                                            class="form-control"
                                                            value=<?php echo("0".$user['phone']); ?>
                                                            required
                                                    /><br/>
                                                    <label>Address</label>
                                                    <input
                                                            type="text"
                                                            name="address"
                                                            id="address"
                                                            class="form-control"
                                                            value=<?php echo($user['address']); ?>
                                                            required
                                                    /><br/>

                                                    <label>Salary</label>
                                                    <input
                                                            type="text"
                                                            name="salary"
                                                            id="salary"
                                                            class="form-control"
                                                            value=<?php echo($user['salary']); ?>
                                                            required
                                                    /><br/>

                                                    <label>Position</label>
                                                    <select class="form-control form-select form-select-lg mb-3" id="position">
                                                        <option value="" selected hidden><?php echo($user['position']);?></option>
                                                        <option value="1">Doctor</option>
                                                        <option value="2">Receptionist</option>
                                                        <option value="3">Economist</option>
                                                        <option value="3">Janitor</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="employee_id" name="employee_id" value="<?php $employee_id ?>"/>
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
                $('#action').val("Edit");
                $('#operation').val("Edit");
            });

            $('#employee_form').on('submit', function(event) {

                const data = {
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    email: $('#email').val(),
                    status: $('#status option:selected').text(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    salary: $('#salary').val(),
                    position: $('#position option:selected').text(),
                    employee_id: $('#employee_id').val(),
                    operation: $('#operation').val()
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
                        $('#employee_form')[0].reset();
                        $('#editEmployee').modal('hide');
                        dataTable.ajax.reload();                    }
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