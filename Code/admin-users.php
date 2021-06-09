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
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
            <br/>
            <div class="card" style="margin-top: auto">
                <div class="card-header">
                    <div class = "row">
                        <div class = "col-sm-9" >USERS </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--  User Table-->
                    <div class="table-responsive" >
                        <table id="user_table" class="display table table-primary" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Role</th>
                                <th>Username</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){

            const dataTable = $('#user_table').DataTable({
                "bDeferRender":true,
                "sPaginationType": "full_numbers",
                // "serverSide":true,
                "ajax":{
                    url:"controller/searchUser.php",
                    type:"POST"
                },
                "columns": [
                    {"data": "user_id"},
                    {"data": "name"},
                    {"data": "surname"},
                    {"data": "role"},
                    {"data": "username"}
                ],
                "oLanguage": {
                    "sProcessing": "Processing...",
                }
            })
        })
    </script>
    </body>
    </html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>