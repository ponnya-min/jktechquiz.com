<?php
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['result_ids'])) {
    $ids = $_POST['result_ids'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $types = str_repeat('i', count($ids));
    $stmt = $conn->prepare("DELETE FROM result WHERE id IN ($placeholders)");

    $stmt->bind_param($types, ...$ids);

    if ($stmt->execute()) {
        header("Location: ../result.php?message=Selected results deleted successfully");
        exit();
    } else {
        echo "Error deleting selected results.";
    }
    $stmt->close();
} else {
    echo "No results selected.";
}

$conn->close();
?>
