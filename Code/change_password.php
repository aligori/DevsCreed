<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Change Password</title>
        <link rel="stylesheet" type="text/css" href="./assets/css/changePassword.css">
    </head>
    <body>
    <form action="change-p.php" method="post">
        <h2>Change Password</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <label>Old Password</label>
        <input type="password"
               name="op"
               placeholder="Old Password">
        <br>

        <label>New Password</label>
        <input type="password"
               name="np"
               placeholder="New Password">
        <br>

        <label>Confirm New Password</label>
        <input type="password"
               name="c_np"
               placeholder="Confirm New Password">
        <br>

        <button type="submit">CHANGE</button>
        <a href="login.php" class="ca">HOME</a>
    </form>
    </body>
    </html>
<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>