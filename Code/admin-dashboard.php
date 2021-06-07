<?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
        include 'model/user.class.php';
        $users = (new Users())->getAllUsers();
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

        <title>Admin Dashboard</title>
    </head>
    <body>
    <?php
    include('shared-components/admin/sidebar1.php');
    ?>
    <div class="main-content">

        <header>
            <div class="search-wrapper">
                <span class="ti-search"></span>
                <input type="search" placeholder="Search">
            </div>

            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
        </header>

        <main>

            <h2 class="dash-title">
                <span class="ti-menu">
                </span>
                Dashboard
            </h2>

            <div class="dash-cards">
                <div class="card-single">
                    <div class="card-body">
                        <span class="ti-briefcase"></span>
                        <div>
                            <h5>Account Balance</h5>
                            <h4>$30,659.45</h4>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="">View all</a>
                    </div>
                </div>

                <div class="card-single">
                    <div class="card-body">
                        <span class="ti-reload"></span>
                        <div>
                            <h5>Pending</h5>
                            <h4>$19,500.45</h4>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="">View all</a>
                    </div>
                </div>

                <div class="card-single">
                    <div class="card-body">
                        <span class="ti-check-box"></span>
                        <div>
                            <h5>Processed</h5>
                            <h4>$20,659</h4>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="">View all</a>
                    </div>
                </div>
            </div>


            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>System Users</h3>

                        <div class="table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th>User id</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tbody>
                                <?php
                                foreach($users as $user) {
                                     ?>
                                    <tr>
                                    <td><?php  echo $user['user_id']?></td>
                                    <td><?php  echo $user['name']?></td>
                                    <td><?php  echo $user['surname']?></td>
                                    <td><?php  echo $user['username']?></td>
                                    <td><?php  echo $user['role']?></td>

                                </tr>
                                    <?php }
                                ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>
    </body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>