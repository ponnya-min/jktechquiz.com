<?php
require('config.php');
session_start();

// Initialize variables
$email_error = "";
$password_error = "";
$login_email = ""; // Initialize to avoid "Undefined variable" error
$login_password = ""; // Initialize to avoid "Undefined variable" error

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login_email = isset($_POST['login-email']) ? trim($_POST['login-email']) : "";
    $login_password = isset($_POST['login-password']) ? trim($_POST['login-password']) : "";

    // Initialize $user to null
    $user = null;

    if (empty($login_email)) {
        $email_error = "Please input email.";
    } else {
        // Check if the email format is valid
        if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please enter a valid email address.";
        } else {
            // Use mysqli query instead of PDO prepare/execute
            $query = "SELECT * FROM users WHERE email = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $login_email);  // "s" stands for string
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if (!$user) {
                    $email_error = "No user exists with this email.";
                }
                $stmt->close();
            } else {
                $email_error = "Failed to prepare query.";
            }
        }
    }

    if (empty($login_password)) {
        $password_error = "Please input password.";
    } elseif ($user && !password_verify($login_password, $user['password'])) {
        $password_error = "Sorry, the password is incorrect.";
    }

    if (empty($email_error) && empty($password_error)) {
        // Generate a unique session token
        //session_regenerate_id(true);
        $session_token = bin2hex(random_bytes(32)); // 64-character random string
       // setcookie("auth_token", $session_token, time() + (30 * 24 * 60 * 60), "/", null);

        // Store the session token in the database
        $updateStmt = $conn->prepare("UPDATE users SET session_token = ?, last_login = NOW() WHERE id = ?");
        $updateStmt->bind_param("si", $session_token, $user['id']); // Bind parameters
        
        // Execute the statement without passing any arguments
        $updateStmt->execute();

        // Store session details
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['session_token'] = $session_token;

        header("Location: index.php"); // Redirect to a success page
        exit();
    }
}


// forget password
// Check if the email exists
$error = ""; // Variable to store error messages
if (isset($_POST['forget-email'])) {
    $email = trim($_POST['forget-email']);

    if (empty($email)) {
        // If email is empty, set the error message
        $error = "Please enter your email.";
        echo json_encode(["success" => false, "error" => $error]);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
        echo json_encode(["success" => false, "error" => $error]);
        exit;
    }

    // Use mysqli query instead of PDO prepare/execute
    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email);  // "s" stands for string
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Email exists, return success response
            echo json_encode(["success" => true, "user_id" => $user['id']]);
        } else {
            // Email does not exist
            $error = "Email does not exist. Unable to reset password.";
            echo json_encode(["success" => false, "error" => $error]);
        }

        $stmt->close();
    } else {
        $error = "Failed to prepare query.";
        echo json_encode(["success" => false, "error" => $error]);
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/JQ.png" type="image/x-icon">
    <!-- Primary Meta Tags -->
    <title>JKTechQuiz</title>
    <meta name="title" content="JKTech Quiz" />
    <meta name="description" content="JKTech Quiz - Test your knowledge with engaging quizzes on technology, programming, and more. Sharpen your skills and challenge yourself with our fun and educational quizzes!
" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://JKTechQuiz.com/" />
    <meta property="og:title" content="JKTech Quiz" />
    <meta property="og:description" content="JKTech Quiz - Test your knowledge with engaging quizzes on technology, programming, and more. Sharpen your skills and challenge yourself with our fun and educational quizzes!
" />
    <meta property="og:image" content="images/Hi.svg" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://JKTechQuiz.com/" />
    <meta property="twitter:title" content="JKTech Quiz" />
    <meta property="twitter:description" content="JKTech Quiz - Test your knowledge with engaging quizzes on technology, programming, and more. Sharpen your skills and challenge yourself with our fun and educational quizzes!
" />
    <meta property="twitter:image" content="images/Hi.svg" />
    <link
        rel="stylesheet"
        href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link
        href="node_modules/bootstrap-icons/font/bootstrap-icons.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="main.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body style="background-color:aliceblue;" class="primary-font">
    <div class="spinner" id="spinner">
        Loading<span></span>
    </div>
    <div class="content">
        <div class="wrapper ">
            <nav
                class="navbar navbar-expand-lg sticky-top bg-white px-4"
                id="header">
                <div class="container-fluid justify-content-center">
                    <a class="navbar-brand me-auto me-sm-auto nav-responsive " href="index.php"><img src="images/JKTechQuiz.svg" alt="" width="50" class="my-0">JKTech<span style="color: #48cae4">Quiz</span></a>

                    <div
                        class="offcanvas offcanvas-end"
                        tabindex="-1"
                        id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                                JKTech<span style="color: #48cae4">Quiz</span>
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul
                                class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a
                                        class="nav-link mx-lg-2"
                                        aria-current="page"
                                        href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mx-lg-2" href="aboutUs.php">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mx-lg-2" href="contact.php">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="register.php" class="login-button ms-1">Register</a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar"
                        aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <section class="py-5 flex-grow-1 d-flex justify-content-center align-items-center">
                <div class="container">
                    <div class="row align-items-center gx-4 justify-content-center">
                        <div class="col-12 col-sm-11 col-md-6 col-xl-5 col-xxl-6 animate__animated animate__bounceIn">
                            <div class="ms-md-2 ms-lg-4"><img class="img-fluid rounded-3" src="images/Computer login-amico.svg"></div>
                        </div>
                        <div class="col-12 col-sm-11 col-md-5 col-xl-5 col-xxl-5 animate__animated animate__bounceIn">
                            <div class="ms-md-2 ms-lg-5">
                                <form method="POST" action="" id="login-form" class="w-100 needs-validation <?php echo !empty($email_error) || !empty($password_error) ? 'was-validated' : ''; ?>" novalidate autocomplete="off">
                                    <h1 class="mb-4 font-weight_700 text-info">Sign In</h1>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <h6 class="ms-1 fw-bold text-info">Email</h6>
                                        <input
                                            type="email"
                                            class="form-control <?php echo !empty($email_error) ? 'is-invalid' : ''; ?>"
                                            name="login-email"
                                            id="login-email"
                                            placeholder="Enter email"
                                            value="<?php echo htmlspecialchars($login_email); ?>"
                                            required />
                                        <div class="invalid-feedback">
                                            <?php echo $email_error; ?>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3 position-relative">
                                        <h6 class="ms-1 fw-bold text-info">Password</h6>
                                        <input
                                            type="password"
                                            class="form-control password-invalid <?php echo !empty($password_error) ? 'is-invalid' : ''; ?>"
                                            name="login-password"
                                            id="login-password"
                                            placeholder="Enter password"
                                            minlength="8"
                                            required />
                                        <button type="button" onclick="togglePassword()" class="toggle-password position-absolute translate-middle-y  border border-0 bg-transparent"><i class="fa fa-eye-slash" id="togglePasswordIcon"></i></button>
                                        <div class="invalid-feedback">
                                            <?php echo $password_error; ?>
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        name="login"
                                        class="btn  btn-info text-white w-100 mt-1 fw-bold shadow fs-5">
                                        Login
                                    </button>

                                    <!-- Forgot Password Link -->
                                    <div class="mt-3 text-center d-flex justify-content-between">
                                        <a href="register.php"><button
                                                type="button"
                                                class="border-0  text-black-50 hover-forgot-text bg-transparent">
                                                No Account? <strong>Register</strong>
                                            </button></a>
                                        <button
                                            type="button"
                                            class="border-0  text-black-50 hover-forgot-text bg-transparent"
                                            data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            Forgot password?
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Footer -->
            <footer class="py-4 footer-shadow bg-white mt-5  ">
                <div class="container">
                    <div class="row align-items-center border-2">
                        <div
                            class="col-12 col-lg-3 text-center text-lg-start d-flex align-items-center justify-content-center pb-3 pb-sm-2 pb-lg-0 pb-xl-0">
                            <img
                                alt="JKT Logo"
                                class="img-fluid rounded-circle"
                                height=""
                                src="images/JKT-logo.jpg"
                                width="50" />
                            <h6 class="fw-bolder ms-2 mb-0">
                                <span class="fw-light fs-6">Organized by</span><br />
                                JKT Digital Institute
                            </h6>
                        </div>
                        <div class="col-12 col-lg-6 navbar-expand text-center text-black-50 pb-4 pb-sm-4 pb-lg-0 pb-xl-0">
                            &copy; <?php echo date("Y"); ?> JKTechQuiz. All rights reserved
                        </div>
                        <div class="col-12 col-lg-3 text-center text-lg-end pb-2 pb-sm-2 pb-lg-0 pb-xl-0">
                            <a class="me-2" href="https://www.facebook.com/jktdigital" target="_blank"><i class="fa-brands fa-facebook fs-3 text-info"></i></a>
                            <a class="me-2" href="http://jktmyanmarint.com/index.html" target="_blank"><i class="fa-solid fa-globe fs-3 text-info "></i></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Forgot Password Modal -->
    <div
        class="modal fade"
        id="staticBackdrop"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered d-flex align-content-center justify-content-center dialog-width mx-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        id="close-btn"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="emailInput" novalidate>
                        <div
                            class="w-25 h-25 p-5 rounded-circle bg-primary m-auto question-mark"></div>
                        <h5 class="card-title text-center mb-4 mt-3 font-weight_700 text-primary_color">
                            Forgot Password
                        </h5>
                        <p class="text-center text-black-50">
                            Please enter your email address <br />to reset your password
                        </p>
                        <div class="form-floating mb-3">
                            <input
                                type="email"
                                class="form-control"
                                id="floatingInput"
                                name="forget-email"
                                placeholder="name@example.com"
                                required />
                            <label for="floatingInput" class="m-0">Email address</label>
                            <div class="invalid-feedback" id="forget-errorMessage"></div>
                        </div>
                        <div class="modal-footer border border-0 p-0">
                            <button
                                type="button"
                                id="forget-submitBtn"
                                class="px-3 text-white py-2 rounded border border-1 border-info submit_bg-color w-100 bg-info">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="login.js"></script>
    <script>
        window.addEventListener('load', () => {
            const spinner = document.querySelector('.spinner');
            const content = document.querySelector('.content');
            if (spinner) {
                spinner.classList.add('spinner--hidden');
                document.body.classList.remove('loading');
                spinner.addEventListener('transitionend', () => {
                    spinner.remove();
                    content.style.display = 'block';
                });
            }
        });
        document.body.classList.add('loading');
    </script>
</body>

</html>