<?php
    session_start();
    include "db_conn.php";
    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {

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
                        <h3>Recent activity</h3>

                        <div class="table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th>User id</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>App Development</td>
                                    <td>15 Aug, 2020</td>
                                    <td>22 Aug, 2020</td>
                                    <td class="td-team">
                                        <div class="img-1"></div>
                                        <div class="img-2"></div>
                                        <div class="img-3"></div>
                                    </td>
                                    <td>
                                        <span class="badge success">Success</span>
                                    </td>
                                </tr>

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