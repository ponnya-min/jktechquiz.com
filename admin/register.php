<?php
require('../config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Prevent duplicate registration for admin@gmail.com
    if ($email === "admin@gmail.com") {
        echo "This email is reserved for the admin!";
        exit();
    }

    // Check if the email already exists in the database
    $sql_check = "SELECT * FROM admins WHERE email = ?";
    if ($stmt_check = mysqli_prepare($conn, $sql_check)) {
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $email_error = "This email is already registered!";
            mysqli_stmt_close($stmt_check);
        } else {
            // Email doesn't exist, proceed to insert
            mysqli_stmt_close($stmt_check);

            $sql_insert = "INSERT INTO admins (name, email, password, role) VALUES (?, ?, ?, 'user')";
            if ($stmt_insert = mysqli_prepare($conn, $sql_insert)) {
                mysqli_stmt_bind_param($stmt_insert, "sss", $name, $email, $password);
                if (mysqli_stmt_execute($stmt_insert)) {
                    echo "Registration successful! <a href='login.php'>Login here</a>";
                } else {
                    echo "Error: Unable to register.";
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                echo "Error: Could not prepare statement.";
            }
        }
    } else {
        echo "Error: Could not prepare statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
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
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">Register</h4>
                        <form method="POST" class="my-login-validation" novalidate>
                            <div class="form-group">
                                <label for="name" class="mb-2 fw-medium">Name</label>
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    required
                                    autofocus />
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="my-2 fw-medium">E-Mail Address</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control <?php echo isset($email_error) ? 'is-invalid' : ''; ?>"
                                    name="email"
                                    required />
                                <?php if (isset($email_error)): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $email_error; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="my-2 fw-medium">Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    required
                                    data-eye />
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>

                            <div class="form-group m-0">
                                <button
                                    type="submit"
                                    class="btn btn-info rounded-2 w-100 text-white shadow-sm fw-bold">
                                    Register
                                </button>
                            </div>
                            <div class="mt-4 text-center fw-medium">
                                Already have an account? <a href="login.php">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/my-login.js"></script>
</body>
</html>
