<?php
require('../config.php');
session_start();

$error_message = '';

if (!isset($_SESSION['reset_email'])) {
    // Redirect if no email in session
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password'] ?? '';

    if (empty($new_password)) {
        $error_message = "Password is required";
    } elseif (strlen($new_password) < 8) {
        $error_message = "Password must be at least 8 characters long";
    } else {
        $email = $_SESSION['reset_email'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare the UPDATE statement
        $sql = "UPDATE admins SET password = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
            if (mysqli_stmt_execute($stmt)) {
                // Clear session and redirect on success
                unset($_SESSION['reset_email']);
                mysqli_stmt_close($stmt);
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error updating password. Please try again.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Failed to prepare the statement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/my-login.css" />
</head>
<body class="my-login-page bg-info">
    <section class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="card-wrapper">
                    <div class="brand shadow-lg bg-white">
                        <img src="img/1-removebg-preview.png" alt="logo" />
                    </div>
                    <div class="card shadow p-2">
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Reset Password</h4>
                            <form method="POST" class="my-login-validation" novalidate>
                                <div class="form-group">
                                    <label for="new-password" class="mb-2 fw-medium">New Password</label>
                                    <input
                                        id="new-password"
                                        type="password"
                                        class="form-control <?php echo (!empty($error_message)) ? 'is-invalid' : ''; ?>"
                                        name="password"
                                        required
                                        autofocus
                                        data-eye
                                    />
                                    <div class="invalid-feedback"><?php echo $error_message ?: 'Password is required'; ?></div>
                                    <div class="form-text text-secondary mt-2 mb-3">
                                        Make sure your password is strong and easy to remember.
                                    </div>
                                </div>
                                <div class="form-group m-0">
                                    <button
                                        type="submit"
                                        class="btn btn-info rounded-2 w-100 text-white shadow-sm fw-bold"
                                    >
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        crossorigin="anonymous"
    ></script>
    <script src="js/my-login.js"></script>
</body>
</html>
