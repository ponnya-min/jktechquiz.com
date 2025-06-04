<?php 
require_once '../../config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["role"])) {
    $id = $_POST["id"];
    $role = $_POST["role"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE admins SET role = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    // Bind parameters: "s" for string (role), "i" for integer (id)
    $stmt->bind_param("si", $role, $id);

    // Execute the statement and return JSON response
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Role updated successfully."]);
    } else {
        echo json_encode(["error" => "Failed to update role: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
