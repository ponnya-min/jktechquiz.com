<?php
require __DIR__ . "/../../../../config.php";
session_start();

$isLoggedIn = isset($_SESSION['user_id']);

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data === null) {
        die("Invalid JSON input.");
    }

    $totalScore = $data['score'];
    $id = $_SESSION['user_id'];
    $type = "FE(AM)-2021/October";
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO result (user_id, quiz_type, score, quiz_date) VALUES (?, ?, ?, ?)";


    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "isis", $id, $type, $totalScore, $date);

        if (mysqli_stmt_execute($stmt)) {
            echo "Data inserted successfully!";
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JKTechQuiz</title>
    <link rel="stylesheet" href="../../../../main.css">
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
        .IPresult-img {
            background: rgba(0, 0, 0, 0.3) url(../../../../images/626f4775-3aec-427d-b099-016eaaa82613.jpg) !important;
            background-blend-mode: darken !important;
            background-size: cover !important;
        }
    </style>
</head>

<body class="bg-info primary-font">
    <nav
        class="navbar navbar-expand-lg sticky-top bg-white px-4"
        id="header">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand me-auto me-sm-auto nav-responsive " href="../../../../index.php"><img src="../../../../images/JKTechQuiz.svg" alt="" width="50" class="my-0">JKTech<span style="color: #48cae4">Quiz</span></a>

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
                                href="../../../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link mx-lg-2"
                                href="../../../../aboutUs.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link mx-lg-2"
                                href="../../../../contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class=""><a href="../../../../user_profile.php" class=" ms-2 btn btn-info me-1 border border-3 border-info rounded-circle text-white"><i class="fa-solid fa-user-graduate"></i></a>
                    <a href="../../../../logout.php" class="login-button ms-1">Logout</a>
                </div>
            <?php else: ?>
                <a href="../../../../login.php" class="login-button ms-1">Login</a>
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
    <section class="text-center IPresult-img bg-white min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="py-5 row">
                <div
                    class="col-md-7 col-lg-5 col-xl-4 ms-auto me-auto py-5">
                    <div
                        class="border border-2 rounded-5 shadow-lg bg-transparent py-4"
                        style="backdrop-filter: blur(20px)">
                        <h1 class="text-white fw-bolder">Quiz Result</h1>
                        <span class="fs-5 text-white">You scored</span>
                        <div
                            class="fs-1 fw-bold mb-3 text-white"
                            id="result-summary"></div>
                        <a
                            class="btn fs-5 btn-info text-white"
                            href="../../../../FEquizSelect.php">Back to choose Year</a><br />
                        <a
                            href="showAnswers.php"
                            class="d-inline-block my-3 link-offset-3 link-info">Check wrong answers</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 footer-shadow bg-white flex-grow-1">
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
                    <a class="me-2" href="https://www.facebook.com/jktdigital" target="_blank"><i class="fa-brands fa-facebook fs-3 text-info"></i></a>
                    <a class="me-2" href="http://jktmyanmarint.com/index.html" target="_blank"><i class="fa-solid fa-globe fs-3 text-info "></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Fetch score, total questions, and results from URL parameters
        const params = new URLSearchParams(window.location.search);
        const totalScore = params.get("totalScore");
        const totalQuestions = params.get("totalQuestions");
        const results = JSON.parse(params.get("results"));

        // Display summary
        document.getElementById(
            "result-summary"
        ).innerText = ` ${totalScore} / ${totalQuestions}`;

        // Display detailed results for wrong answers
        const detailedResultsContainer =
            document.getElementById("detailed-results");
        if (results && results.length > 0) {
            results.forEach((result, index) => {
                const resultDiv = document.createElement("div");
                resultDiv.innerHTML = `
            <div class="p-4 border border-2 rounded shadow-sm mb-5 bg-white">
                <h5 class=""><strong>Question ${result.questionNumber}</strong>: ${
                    result.question
                }</h5><br>
                ${
                    result.image
                        ? `<img src="${result.image}" alt="Question Image" class="mw-100 h-auto" />`
                        : ""
                }
                <p style="font-size:18px"><strong>Your Answer:</strong> ${
                    result.userAnswer || "No Answer Selected"
                }</p>
                <p style="font-size:18px"><strong>Correct Answer:</strong> ${
                    result.correctAnswer
                }</p>
            </div>
            `;
                detailedResultsContainer.appendChild(resultDiv);
            });
        }
    </script>
    <script src="../../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../login.js"></script>
    <script src="quiz.js"></script>
</body>

</html>