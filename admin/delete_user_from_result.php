<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $userId = (int)$_POST["user_id"];

    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $stmt->close();

            // Delete user's results
            $stmt2 = $conn->prepare("DELETE FROM result WHERE user_id = ?");
            if ($stmt2) {
                $stmt2->bind_param("i", $userId);
                $stmt2->execute();
                $stmt2->close();
            }

            $conn->close();
            header("Location: ../index.php?message=User deleted successfully");
            exit();
        } else {
            echo "Error deleting user.";
        }
    } else {
        echo "Failed to prepare the statement.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
