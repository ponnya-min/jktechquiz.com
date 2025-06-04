<?php
require_once '../../config.php';

if (isset($_POST['result_id'])) {
    $resultId = (int)$_POST['result_id'];

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM result WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $resultId);
        $stmt->execute();
        $stmt->close();
        header('Location: ../result.php'); // Redirect back to the results page after deletion
        exit;
    } else {
        die("Error: " . htmlspecialchars($conn->error));
    }
}
?>

