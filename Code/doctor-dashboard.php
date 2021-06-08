<?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'doctor') {
?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <?php include('shared-components/includes.php') ?>
    <title>Doctor Dashboard</title>
</head>
<body>
<?php
include('shared-components/admin/sidebar1.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <nav aria-label="breadcrumb" style="margin-top: 30px;">
            <ol class="breadcrumb">
                <h5 class="text-secondary">
                    Hello, <?php echo $_SESSION['user']['name']." ";  echo $_SESSION['user']['surname'] ?>
                </h5>
            </ol>
        </nav>
    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>