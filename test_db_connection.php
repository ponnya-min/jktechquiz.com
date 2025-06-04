<?php
$host = 'localhost';  // Usually localhost for shared hosting
$dbname = 'zipszwh1_itpecexam';
$username = 'zipszwh1_jktadmin';
$password = 'jktadmin2025';

// Try connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully to the database!";
}
?>
