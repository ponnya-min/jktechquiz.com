<?php
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_ids"])) {
    $userIds = $_POST["user_ids"];

    // Sanitize and validate IDs
    $userIds = array_filter($userIds, fn($id) => is_numeric($id));
    if (empty($userIds)) {
        echo "No valid users selected.";
        exit;
    }

    // Create placeholders for prepared statement
    $placeholders = implode(',', array_fill(0, count($userIds), '?'));

    $sql = "DELETE FROM users WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Dynamically bind parameters
        $types = str_repeat('i', count($userIds)); // 'i' for integer
        $stmt->bind_param($types, ...$userIds);

        if ($stmt->execute()) {
            header("Location: ../index.php?message=Selected users deleted successfully");
            exit;
        } else {
            echo "Failed to delete selected users.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare delete statement.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
