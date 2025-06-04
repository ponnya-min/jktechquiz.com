<?php
require("../../config.php");

if (isset($_POST['date'])) {
    $date = $_POST['date'];

    $sql = "DELETE FROM feedback WHERE date = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $date); // "s" = string
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $stmt->close();
    } else {
        echo "error preparing statement";
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
