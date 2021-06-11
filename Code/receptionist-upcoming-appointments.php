<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
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
                <li class="breadcrumb-item active" aria-current="page">Doctors</li>
            </ol>
        </nav>
        <br/>
        <br/>
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
    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>