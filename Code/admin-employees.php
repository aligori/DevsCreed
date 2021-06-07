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
                        <li class="breadcrumb-item active" aria-current="page">Employees</li>
                    </ol>
                </nav>
                <br/>
                <div class="card" style="margin-top: auto">
                    <div class="card-header">
                        <div class = "row">
                            <div class = "col-sm-9" >EMPLOYEES </div>
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
                    <div class="card-body">
                    <!--  Employee Table-->
                       <div class="table-responsive" >
                           <table id="employees_table" class="display table table-primary" >
                               <thead>
                               <tr>
                                   <th>Employee id</th>
                                   <th>Full Name</th>
                                   <th>Email</th>
                                   <th>Phone</th>
                                   <th>Birthdate</th>
                                   <th>Status</th>
                                   <th>Edit</th>
                               </tr>
                               </thead>
<!--                               <tfoot>-->
<!--                               <tr>-->
<!--                                   <th>Employee id</th>-->
<!--                                   <th>Full Name</th>-->
<!--                                   <th>Email</th>-->
<!--                                   <th>Phone</th>-->
<!--                                   <th>Birthdate</th>-->
<!--                                   <th>Status</th>-->
<!--                                   <th>Edit</th>-->
<!--                               </tr>-->
<!--                               </tfoot>-->
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
                                    <label>Phone</label>
                                    <input type="phone" name="phone" id="phone" class="form-control"><br/>
<!--                                    <label>Position</label>-->
<!--                                    <input type="text" name="position" id="position" class="form-control"><br/>-->
                                    <label>Birthdate</label>
                                    <input type="date" name="birthday" id="birthday" class="form-control"><br/>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="create_user">
                                        <label class="form-check-label" for="flexCheckChecked"">
                                            Create User Account
                                        </label>
                                    </div>
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

    <script type="text/javascript">

        $(document).ready(function(){
            $('#addEmployee').click(function(){
                // $('#employee_form')[0].reset();
                $('.modal-title').text("Add Employee Details");
                $('#action').val("Add");
                $('#operation').val("Add");
            });

            const dataTable = $('#employees_table').DataTable({
                "bDeferRender":true,
                "sPaginationType": "full_numbers",
                // "serverSide":true,
                "ajax":{
                    url:"controller/searchEmployees.php",
                    type:"POST"
                },
                "columns": [
                    {"data": "employee_id"},
                    {"data": "full_name"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "birthday"},
                    {"data": "status"},
                    {"data": "edit"}
                ],
                "oLanguage": {
                    "sProcessing": "Processing...",
                }
            })

            $(document).on('submit', '#employee_form', function(event){
                event.preventDefault();
                const name = $('#name').val();
                const surname = $('#surname').val();
                const email = $('#email').val();
                const phone = $('#phone').val();
                const birthday = $('#birthday').val();
                console.log(new FormData(this))
                //You can check input
                $.ajax({
                    url: "controller/insertEmployee.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#employee_form')[0].reset();
                        $('#addEmployee').modal('hide');
                        dataTable.ajax.reload();
                    }
                })
            });
        })
    </script>
    </body>
</html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>