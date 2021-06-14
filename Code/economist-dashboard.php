<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'economist') {
    include_once('model/db_conn.php');
    include_once('model/transaction.class.php');
    $dbh = Database::get_connection();
    $dailyTransaction = (new Transaction($dbh))->get_DailyTransactionValue();
    $monthlyTransaction = (new Transaction($dbh))->get_MonthlyTransactionValue();
    $spent = (new Transaction($dbh))->get_ValueSpent();
    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Economist Dashboard</title>
</head>
<body>
<?php
include('shared-components/economist/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>

        <nav aria-label="breadcrumb" style="margin-top: 60px;">
            <ol class="breadcrumb">
                <h4 class="text-secondary">
                    Hello, <?php echo $_SESSION['user']['name'];  echo $_SESSION['user']['surname'] ?>
                </h4>
            </ol>
        </nav>

        <div class="dash-cards">
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-money" style="color: #0a53be"></span>
                    <div>
                        <h5>Daily Transaction Value</h5>
                        <h4><?php echo $dailyTransaction["sum"].' LEKË' ?></h4>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="economist-dailyTransactions.php">View transactions</a>
                </div>
            </div>

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-money" style="color: #3EC5AD"></span>
                    <div>
                        <h5>Monthly Transaction Value</h5>
                        <h4><?php echo $monthlyTransaction["sum"].' LEKË' ?></h4>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="economist-monthlyTransactions.php">View transactions</a>
                </div>
            </div>

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-money" style="color: #FFA7A7"></span>
                    <div>
                        <h5>Expenditure</h5>
                        <h4><?php echo $spent["sum"].' LEKË' ?></h4>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="economist-expenditure.php">View transactions</a>
                </div>
            </div>
        </div>
        <br/>

    </main>
</div>
</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>