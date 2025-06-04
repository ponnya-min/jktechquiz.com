<?php
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    // Prepare the statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: ../index.php?message=User deleted successfully");
            exit();
        } else {
            echo "Error deleting user.";
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

