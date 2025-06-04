<?php
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM users WHERE DATEDIFF(NOW(), last_login) > 180";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: ../index.php?message=Expired accounts deleted successfully");
            exit();
        } else {
            echo "Error deleting expired accounts.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the statement.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
