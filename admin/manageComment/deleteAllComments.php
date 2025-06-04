<?php
require("../../config.php");

$sql = "DELETE FROM feedback";
$stmt = $conn->prepare($sql);

if ($stmt) {
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "error: " . htmlspecialchars($conn->error);
}

$conn->close();
?>
