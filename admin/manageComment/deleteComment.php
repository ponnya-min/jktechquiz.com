<?php
require("../../config.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['id'])) {
        $commentId = (int)$_POST['id'];

        // Check if comment exists
        $checkSql = "SELECT * FROM feedback WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);
        if ($checkStmt) {
            $checkStmt->bind_param("i", $commentId);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // Delete query
                $sql = "DELETE FROM feedback WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("i", $commentId);
                    if ($stmt->execute()) {
                        echo "success";
                    } else {
                        echo "execute_error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "prepare_error: " . $conn->error;
                }
            } else {
                echo "not_found";
            }
            $checkStmt->close();
        } else {
            echo "prepare_error: " . $conn->error;
        }
    } else {
        echo "invalid";
    }
} else {
    echo "invalid_request";
}

$conn->close();
?>
