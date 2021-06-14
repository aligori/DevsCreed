<?php
require_once("model/db_conn.php");
require_once("model/user.class.php");

session_start();
$dbh = Database::get_connection();
$user_instance = new Users($dbh);
$user_instance->setOffline($_SESSION['user_id']);
session_unset();
session_destroy();

header("Location: ./login.php");