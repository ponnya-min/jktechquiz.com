<?php
require('../config.php');

$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate the email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare the SQL statement with ? placeholder for mysqli
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            $error_message = "Database error: " . mysqli_error($conn);
        } else {
            // Bind the parameter (s = string)
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                session_start();
                $_SESSION['reset_email'] = $email;
                header("Location: reset.php");
                exit(); // stop further execution after redirect
            } else {
                $error_message = "Email address not found.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
        $error_message = "Invalid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Forgot Password</title>
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
                            <h4 class="card-title fw-bold">Forgot Password</h4>
                            <form method="POST" class="my-login-validation" novalidate>
                                <div class="form-group">
                                    <label for="email" class="mb-2 fw-medium">E-Mail Address</label>
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control <?php echo (!empty($error_message)) ? 'is-invalid' : ''; ?>"
                                        name="email"
                                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                                        required
                                        autofocus
                                    />
                                    <div class="invalid-feedback"><?php echo $error_message ?: 'Email is invalid'; ?></div>
                                    <div class="form-text text-secondary my-2">
                                        By clicking "Reset Password", we will send a link to reset your password.
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
</body>
</html>
