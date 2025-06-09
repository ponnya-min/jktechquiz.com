<?php
require("../../config.php");

// Enable error reporting (only for development; disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: text/plain"); // Ensures plain text response for JS

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($commentId !== false && $commentId !== null) {
        // Check if comment exists
        $checkSql = "SELECT id FROM feedback WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);
        if ($checkStmt) {
            $checkStmt->bind_param("i", $commentId);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $checkStmt->close();

                // Delete comment
                $deleteSql = "DELETE FROM feedback WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                if ($deleteStmt) {
                    $deleteStmt->bind_param("i", $commentId);
                    if ($deleteStmt->execute()) {
                        echo "success";
                    } else {
                        echo "error: " . $deleteStmt->error;
                    }
                    $deleteStmt->close();
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "not_found";
                $checkStmt->close();
            }
        } else {
            echo "error: " . $conn->error;
        }
    } else {
        echo "invalid_id";
    }
} else {
    echo "invalid_request";
}

$conn->close();
?>
