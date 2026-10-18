<?php
$host = "sql204.infinityfree.com";
$user = "if0_43202048";
$pass = "Naraja0606";
$dbname = "if0_43202048_inventory_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// make sure the user is logged in
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function check_admin() {
    check_login();
    if ($_SESSION['role'] != 'admin') {
        die("Access denied. Admin only.");
    }
}
?>
