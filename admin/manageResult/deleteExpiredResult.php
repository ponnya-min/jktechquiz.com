<?php
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM result WHERE DATEDIFF(NOW(), quiz_date) > 180";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: ../result.php?message=Expired accounts deleted successfully");
            exit();
        } else {
            echo "Error deleting expired accounts: " . htmlspecialchars($stmt->error);
        }
    } else {
        echo "Error preparing the statement: " . htmlspecialchars($conn->error);
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
