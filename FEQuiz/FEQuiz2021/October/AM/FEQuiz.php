<?php
require __DIR__ . "/../../../../config.php";
session_start();
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
// Retrieve the enableTimer parameter
$enableTimer = isset($_GET['enableTimer']) ? $_GET['enableTimer'] : '0';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JKTechQuiz</title>
    <link rel="stylesheet" href="../../../../main.css" />
    <link
        rel="stylesheet"
        href="../../../../node_modules/bootstrap-icons/font/bootstrap-icons.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link
        rel="stylesheet"
        href="../../../../node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="shortcut icon" href="../../../../images/JQ.png" type="image/x-icon">
    <style>
        .twinkle {
            animation: flash 1s infinite;
        }

        @keyframes flash {

            0%,
            100% {
                color: red;
            }

            50% {
                color: white;
            }
        }

        #timer {
            font-size: 2rem;
            font-weight: bold;
        }

        .answered {
            background-color: #48cae4 !important;
            color: white !important;
            pointer-events: none;
            cursor: default;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px !important;

        }

        .unanswered:hover {
            background-color: #48cae4 !important;
            color: white !important;
        }


        .question-link.active {
            background-color: #48cae4 !important;
            color: white !important;
            transform: scale(1.05) !important;
        }

    </style>
</head>

<body class="bg-info primary-font">
    <nav
        class="navbar navbar-expand-lg sticky-top bg-white px-4"
        id="header">
        <div class="container-fluid justify-content-center">

            <a class="navbar-brand me-auto me-sm-auto nav-responsive " href="#" data-target-link="../../../../index.php"><img src="../../../../images/JKTechQuiz.svg" alt="" width="50" class="my-0">JKTech<span style="color: #48cae4">Quiz</span></a>
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
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a href="#" class="nav-link mx-lg-2" data-target-link="../../../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link mx-lg-2" data-target-link="../../../../aboutUs.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link mx-lg-2" data-target-link="../../../../contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link mx-lg-2" data-target-link="../../../../FEquizSelect.php">FE(Quiz)</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex">
                <!-- sidebar -->
                <button
                    id="click"
                    class="btn p-0 me-2 unanswered_sb"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions"
                    aria-controls="offcanvasWithBothOptions"
                    title="Unanswered question">
                    <i class="fa-solid fa-pencil text-info fs-4  h-100" style="padding:5px" ></i>
                </button>
                <div id="timer" style="font-size: 1.6875rem;">03:30:00</div>
            </div>


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
    <!-- unanswered sidebar -->
    <div class="offcanvas offcanvas-start " data-bs-scroll="false" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title fw-bolder" id="offcanvasWithBothOptionsLabel">Quiz numbers</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="alert alert-info" role="alert">
                <h6 class="fw-bold">Notes</h6>
                If a question is unanswered, you can click the button to navigate directly to that question and provide your response. However, if the question is already answered, the button will be disabled, and you won't be able to click it again.
            </div>

            <h5 class="mb-4">Unanswered Questions</h5>

            <div id="uq-num" class="d-flex row-gap-4 column-gap-5 flex-wrap justify-content-center"></div>
            <h5 class="my-4">Answered Questions</h5>
            <div id="aq-num" class="d-flex row-gap-4 column-gap-5 flex-wrap justify-content-center"></div>
        </div>
    </div>


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 ">
                <div id="quiz-container"></div>
                <!-- Hidden form to carry the total score -->
                <form
                    id="scoreForm"
                    action="results.php"
                    method="GET"
                    style="display: none">
                    <input
                        type="hidden"
                        name="totalScore"
                        id="totalScore" />
                </form>
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="d-flex gap-3">
                        <button id="pgi-leftBtn" class="quiz-button"><i class="fa-solid fa-angles-left"></i></button>
                        <button id="prev-button" class="quiz-button"><i class="fa-solid fa-angle-left"></i></button>
                    </div>
                    <div
                        id="pagination"
                        class="pagination d-flex flex-row justify-content-center page-link shadow flex-wrap m-4"></div>
                    <div class="d-flex gap-3">
                        <button id="next-button" class="quiz-button"><i class="fa-solid fa-angle-right"></i></button>
                        <button id="pgi-nextBtn" class="quiz-button"><i class="fa-solid fa-angles-right"></i></button>
                    </div>

                </div>
                <button type="button" class="w-100 bg-info shadow border border-3 border-white d-block py-2 rounded text-white mt-3" data-bs-toggle="modal" data-bs-target="#submitQuiz">Submit Quiz</button>
            </div>
        </div>
    </div>
    <!--Submit Quiz Modal -->
    <div class="modal fade" id="submitQuiz" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger py-2" data-bs-dismiss="modal">Close</button>
                    <button id="submit" class="py-2 px-3 bg-info  border border-3 border-white rounded-2 text-white">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="py-4 footer-shadow bg-white">
        <div class="container">
            <div class="row align-items-center border-2">
                <div
                    class="col-12 col-lg-3 text-center text-lg-start d-flex align-items-center justify-content-center pb-3 pb-sm-2 pb-lg-0 pb-xl-0">
                    <img
                        alt="JKT Logo"
                        class="img-fluid rounded-circle"
                        height=""
                        src="../../../../images/JKT-logo.jpg"
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
                    <a class="me-2" href="#" data-target-link="https://www.facebook.com/jktdigital" target="_blank"><i class="fa-brands fa-facebook fs-3 text-info"></i></a>
                    <a class="me-2" href="#" data-target-link="http://jktmyanmarint.com/index.html" target="_blank"><i class="fa-solid fa-globe fs-3 text-info "></i></a>
                </div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="leavePageModal" tabindex="-1" aria-labelledby="leavePageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leavePageModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to leave the exam page? Your progress may not be saved.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" id="confirmLeaveButton" class="btn btn-info text-white">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- time Up modal -->
        <div class="modal fade" id="timesUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="timesUpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info fw-bolder" id="timesUpModalLabel">Time's Up!</h5>
                    </div>
                    <div class="modal-body ">
                        Time's up! You can't continue your exam.
                    </div>
                    <div class="modal-footer">
                        <span id="time-left"></span> <!-- Countdown display -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="2021A_FE.js"></script>
    <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../login.js"></script>

</body>

</html>