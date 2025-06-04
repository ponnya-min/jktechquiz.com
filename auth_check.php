<?php
require('config.php'); // Database connection

if (isset($_COOKIE["auth_token"])) {
    $token = $_COOKIE["auth_token"];

    // Query to fetch all users
    $query = "SELECT * FROM users";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($value = $result->fetch_assoc()) {
            if ($token === $value['session_token']) {
                // The token is valid, so we continue the session
          
                $_SESSION["user_id"] = $value['id'];
            }
        }
    }
}
?>