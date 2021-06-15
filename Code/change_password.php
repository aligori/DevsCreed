<?php
session_start();
if (isset($_SESSION['user_id'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Change Password</title>
        <link rel="stylesheet" type="text/css" href="./assets/css/changePassword.css">
    </head>
    <body>
    <form action="controller/check-change.php" method="POST">
        <h3>Change Password</h3>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <label>Old Password</label>
        <input type="password"
               name="old_password"
               placeholder="Old Password" required>
        <br>

        <label>New Password</label>
        <input type="password"
               name="new_password"
               placeholder="New Password" required>
        <br>

        <label>Confirm New Password</label>
        <input type="password"
               name="confirmed_pass"
               placeholder="Confirm New Password" required>
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