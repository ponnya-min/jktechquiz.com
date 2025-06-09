<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['result_ids'])) {
    $ids = $_POST['result_ids'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $stmt = mysqli_prepare($conn, "DELETE FROM result WHERE id IN ($placeholders)");
    mysqli_stmt_bind_param($stmt, $types, ...$ids);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
