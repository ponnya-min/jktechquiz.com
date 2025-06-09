<?php
require("../../config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "DELETE FROM feedback";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
