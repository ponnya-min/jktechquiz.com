<?php
session_start();
require('../config.php'); // Database connection

// If needed, check for session login
if (!isset($_SESSION["id"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}
?>
