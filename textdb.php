<?php
$servername = "localhost";
$username = "zipszwh1_jktadmin";
$password = "jktadmin2025";
$dbname = "zipszwh1_itpecexam";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}
?>