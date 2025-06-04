<?php
// Database configuration
$host = 'localhost';         // Replace with your database host
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'itpecexam'; // Replace with your database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Optional: Connection success message (comment out in production)
// echo "Database connected successfully.";
?>