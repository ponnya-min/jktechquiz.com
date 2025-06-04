<?php
//session_save_path('/home/zipszwh1/public_html/sessions');
session_start();
require_once 'config.php'; // Include database connection
$isLoggedIn = isset($_SESSION['user_id']);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $text = htmlspecialchars($_POST['message']);
    $date = date("Y-m-d"); // Current date

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO feedback (name, email, text, date) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters (assuming name, email, text, and date are already defined)
            $stmt->bind_param("ssss", $name, $email, $text, $date); // "ssss" means 4 strings

            // Execute the statement
            if ($stmt->execute()) {
                // Success - Display modal
                echo '<script>
                        window.onload = function() {
                            const modal = new bootstrap.Modal(document.getElementById("staticBackdrop"));
                            modal.show();
                        }
                        </script>';
            } else {
                echo "Error: Could not submit your feedback.";
            }

            // Close the statement
            $stmt->close();
        } else {
            die("Error preparing SQL statement: " . $conn->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/JQ.png" type="image/x-icon">
    <title>JKTechQuiz - Contact</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css" />
    <style>
        .contact-wallpaper {
            background: rgba(0, 0, 0, 0.8) url(images/email-marketing-newsletter-email-envelope-c5ebd39239962df8dbd533b955c76bfa.jpg);
            background-blend-mode: darken;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="primary-font">
    <!-- Spinner -->
    <div class="spinner" id="spinner">
        Loading<span></span>
    </div>
    <div class="content">
        <div class="wrapper mb-5">
            <!-- Navbar -->
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
                                    <a class="nav-link mx-lg-2 active" href="contact.php">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php if ($isLoggedIn): ?>
                        <div class=""><a href="user_profile.php" class=" ms-2 btn btn-info me-1 border border-3 border-info rounded-circle text-white"><i class="fa-solid fa-user-graduate"></i></a>
                            <a href="logout.php" class="login-button ms-1">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="login-button ms-1">Login</a>
                    <?php endif; ?>
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

            <section class="py-5 contact-wallpaper">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="text-center" data-aos="zoom-in">
                                <h2 class="display-5 fw-bold text-white">Contact Us</h2>
                                <p class="lead text-white">We'd love to hear from you! Fill out the form below, and we'll get back to you as soon as possible.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container mt-5 mb-4">
                <div class="row align-items-center justify-content-center">
                    <!-- Left Column: Image -->
                    <div class="col-md-7 text-center" data-aos="fade-right">
                        <img src="images/Contact-us.svg" alt="Contact Us" class="img-fluid rounded w-100" />
                    </div>

                    <!-- Right Column: Form -->
                    <div class="col-md-5 pb-4" data-aos="fade-left">
                        <form id="contactForm" method="POST" action="contact.php">
                            <div class="mb-3">
                                <p class="fw-bold mb-1" style="color: #3fd3ed; font-size: 18px;">Name</p>
                                <input type="text" required class="form-control" name="name" id="name" style="border: 2px solid #00d2f542; background-color: #00d2f542;" />
                            </div>
                            <div class="mb-3">
                                <p class="fw-bold mb-1" style="color: #3fd3ed; font-size: 18px;">Email</p>
                                <input type="email" required class="form-control" name="email" id="email" style="border: 2px solid #00d2f542; background-color: #00d2f542;" />
                            </div>
                            <div class="mb-3">
                                <p class="fw-bold mb-1" style="color: #3fd3ed; font-size: 18px;">Message</p>
                                <textarea class="form-control" name="message" id="message" required rows="5" style="border: 2px solid #00d2f542; background-color: #00d2f542;"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info px-4 py-2 text-white">Submit ✓</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="py-4 footer-shadow">
            <div class="container">
                <div class="row align-items-center border-2">
                    <div class="col-12 col-lg-3 text-center text-lg-start d-flex align-items-center justify-content-center pb-3 pb-sm-2 pb-lg-0 pb-xl-0">
                        <img alt="JKT Logo" class="img-fluid rounded-circle" src="images/JKT-logo.jpg" width="50" />
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <img src="images/check-circle-svgrepo-com.svg" alt="" class="position-absolute" width="100" style="top:-50px;left:200px;"><br>
                </div>
                <div class="modal-body">
                    <h3 class="fw-bolder text-center">Thank You</h3>
                    <p class="text-center">Your details have been successfully submitted.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info text-white w-100" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>



    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
            AOS.init();
        });
        document.body.classList.add('loading');
    </script>
</body>

</html>