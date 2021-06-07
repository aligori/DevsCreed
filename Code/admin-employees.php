<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    include 'model/user.class.php';
    $users = Users::getAllUsers();
    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link href='assets/css/sidebar1.css' rel='stylesheet'>
    <!--        <link href="assets/public/css/theme.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
<?php
include('shared-components/admin/sidebar1.php');
?>
<div class="main-content">

    <header>
       <div class="navbar navbar-dark">
           <a href="admin-dashboard.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
           <a><?php echo $_SESSION['user']['username'] ?></a>
       </div>
    </header>

    <main>
        <nav aria-label="breadcrumb" style="margin-top: 60px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employees</li>
            </ol>
        </nav>

        <div class = "container" >
            <div class = "row">
                <div class = "col-sm-9" ></div>
                <div class = "col-sm-3"  align="right">
                    <button type="submit"
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#addEmployee"
                    > <i class="fas fa-plus-circle"></i>
                        Add User
                    </button>
                </div>
            </div>
        </div>
<!--  Employee Table-->
        <div class="card" style="margin: 30px 30px 0px 30px;">
            <div class="card-header">
                <strong class="">Employees</strong>
            </div>
            <div class="card-body">
                <br> <br>
                <div class="table-responsive">
                    <table id="employees" class="table table-striped">
                        <thead>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
<!-- Add Employee Modal-->
        <div id="addEmployee" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="employee_form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Employee</h4>
                            <button type="button" class="close" data-dismiss="modal">&times</button>
                        </div>
                        <div class="modal-body">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"><br/>
                            <label>Surname</label>
                            <input type="text" name="surname" id="surname" class="form-control" placeholder="Enter surname"><br/>
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter "><br/>
                            <label>Birthdate</label>
                            <input type="date" name="birthday" id="birthday" class="form-control"><br/>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="employee_id" id="employee_id"/>
                            <input type="hidden" name="operation="operation"/>
                            <input type="submit" name="action" id="action" class="btn btn-primary" value="Add"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> Close</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>