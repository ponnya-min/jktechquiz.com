<?php
session_start();

// Include the database connection file
require('config.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement with mysqli
    $stmt = $conn->prepare("UPDATE users SET session_token = NULL WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // Clear session data
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}
?>
