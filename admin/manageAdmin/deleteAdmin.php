<?php
require_once '../../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($adminId > 0) {
        // Prevent deleting main admin (optional)
        if ($adminId === 1) {
            $_SESSION['error'] = 'Cannot delete the main admin.';
            header("Location: ../adminRole.php");
            exit;
        }

        // Prepare delete statement
        $stmt = mysqli_prepare($conn, "DELETE FROM admins WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $adminId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['message'] = 'Admin deleted successfully.';
            } else {
                $_SESSION['error'] = 'Admin not found.';
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = 'Failed to prepare statement.';
        }
    } else {
        $_SESSION['error'] = 'Invalid admin ID.';
    }

    header("Location: ../adminRole.php");
    exit;
}
?>
