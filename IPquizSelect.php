<?php
session_start();
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="main.css" />
    <style>
        footer {
            margin-top: auto;
            text-align: center;
            padding: 1rem;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="primary-font">
    <!-- Spinner -->
    <div class="spinner" id="spinner">
        Loading<span></span>
    </div>
    <div class="content">
        <div class="wrapper">
            <!-- Navbar -->
            <nav
                class="navbar navbar-expand-lg sticky-top bg-white px-4"
                id="header">
                <div class="container-fluid justify-content-center">
                    <a class="navbar-brand me-auto me-sm-auto nav-responsive " href="index.php"><img src="images/JKTechQuiz.svg" alt="logo" width="50" class="my-0">JKTech<span style="color: #48cae4">Quiz</span></a>

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
                    <!-- <a href="login.php" class="login-button">Login</a> -->
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
            <!-- Content -->
            <div class="container text-center my-5">
                <h1 class="mb-4 fw-bold text-danger">IP</h1>
                <p class="mb-3">Information Technology Passport Examination.<br>Be ready and prepared for the Exam by testing your skill on our website.<br><span class=" text-danger">Warning:You are not able to continue the test when the timer gets 00:00:00</span></p>
                <div class="d-flex flex-wrap align-items-center justify-content-evenly mx-5">
                    <div class="text-start mb-3  d-flex flex-col justify-content-center align-items-center">
                        <div id="enableTimer" class="IPtoggle-switch" onclick="handleCheckboxChange(this)  ">
                            <div class="slider"></div>
                        </div>
                        <span class="fw-bold ms-2">Timer Set</span>
                    </div>
                    <div class=" text-start mb-3 ms-2 d-flex flex-col justify-content-center align-items-center">
                        <div id="enableRandomQuiz" class="IPtoggle-switch" onclick="handleRandomCheckboxChange(this)  ">
                            <div class="slider"></div>
                        </div>
                        <span class="fw-bold ms-2">Random Quiz</span>
                    </div>
                </div>

                <!-- Search Box -->
                <div class="container text-center mb-2 right-3">
                    <div class="input-group justify-content-center">
                        <div class="form-outline" data-mdb-input-init>
                            <input
                                type="text"
                                class="border border-danger-subtle border-2 px-2 py-1 outline-none rounded"
                                id="searchInput"
                                onkeyup="searchYear()"
                                placeholder="search year"
                                pattern="\d*" />
                        </div>

                    </div>
                </div>
                <div
                    class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 my-4" >
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2024</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2024/October/2024A_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">October</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2024</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2024/April/2024S_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">&nbsp;&nbsp;April&nbsp;&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2023</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2023/October/2023A_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">October</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2023</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2023/April/2023S_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">&nbsp;&nbsp;April&nbsp;&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2022</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2022/Oct/2022A_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">October</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2022</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2022/April/2022S_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">&nbsp;&nbsp;April&nbsp;&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2021</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2021/October/2021A_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">October</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card quiz-card border m-auto">
                            <div class="card-body box-shadow_IPcolor">
                                <p class="card-text font-weight_700">2021</p>
                                <div class="dropdown">
                                    <a
                                        href="IPQuiz/IPQuiz2021/April/2021S_IP.php"
                                        class="btn text-white dropbtn dropbtn-red w-100 rounded text-decoration-none">&nbsp;&nbsp;April&nbsp;&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="py-4 footer-shadow">
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
        // searchYear
        function searchYear() {
            var input, filter, cols, year, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase(); // Convert input to uppercase to make it case-insensitive
            cols = document.querySelectorAll('.col'); // Select all columns

            // Loop through all columns and hide those that do not match the input year
            for (i = 0; i < cols.length; i++) {
                year = cols[i].querySelector('.card-text'); // Get the year (the .card-text element) inside the column
                txtValue = year.textContent || year.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    cols[i].style.display = 'block'; // Show the column if it matches the search query
                } else {
                    cols[i].style.display = 'none'; // Hide the column if it doesn't match
                }
            }
        }

        // Prevent non-numeric characters from being entered
        document.getElementById('searchInput').addEventListener('input', function(event) {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        });
        //enable time set
        function handleCheckboxChange(checkbox) {
            checkbox.classList.toggle('active');
            const enableTimer = checkbox.classList.contains('active') ? "1" : "0";
            document.querySelectorAll('a').forEach(link => {
                const url = new URL(link.href);
                url.searchParams.set('enableTimer', enableTimer);
                link.href = url.toString();
                console.log("Updated Link: ", link.href);
            });
        }
        //enable random quiz
        function handleRandomCheckboxChange(toggle) {
            toggle.classList.toggle('active');
            // Check if the toggle is active
            const enableRandomQuiz = toggle.classList.contains('active') ? "1" : "0";
            document.querySelectorAll('a').forEach(link => {
                const url = new URL(link.href, window.location.origin);
                url.searchParams.set('enableRandomQuiz', enableRandomQuiz);
                link.href = url.toString();
                console.log("Updated Link: ", link.href);
            });
            
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="login.js"></script>
</body>

</html>