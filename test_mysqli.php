<?php
$host = "localhost";
$user = "zipszwh1_jktadmin";
$password = "jktadmin2025";
$database = "zipszwh1_itpecexam";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "MySQLi connection successful!";
?>
