<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JKTechQuiz</title>
    <link rel="stylesheet" href="../../../main.css">
    <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="shortcut icon" href="../../../images/JQ.png" type="image/x-icon">
    <style>
        .btn-group button.active {
            background-color: #000957 !important;
            color: white !important;
            border-color: #000957 !important;
        }
    </style>
</head>

<body class="bg-info primary-font">
    <nav
        class="navbar navbar-expand-lg sticky-top bg-white px-4"
        id="header">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand me-auto me-sm-auto nav-responsive " href="../../../index.php"><img src="../../../images/JKTechQuiz.svg" alt="" width="50" class="my-0">JKTech<span style="color: #48cae4">Quiz</span></a>

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
                                href="../../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link mx-lg-2"
                                href="../../../aboutUs.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link mx-lg-2"
                                href="../../../contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class=""><a href="../../../user_profile.php" class=" ms-2 btn btn-info me-1 border border-3 border-info rounded-circle text-white"><i class="fa-solid fa-user-graduate"></i></a>
                    <a href="../../../logout.php" class="login-button ms-1">Logout</a>
                </div>
            <?php else: ?>
                <a href="../../../login.php" class="login-button ms-1">Login</a>
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

    <div class="container py-5 min-vh-100 secondary-font">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-center mb-3 gap-2">
                    <div class="btn-group w-100 flex-wrap" role="group" aria-label="Answer Filters">
                        <button id="all-answers-btn" class="btn btn-primary primary-font">All </button>
                        <button id="wrong-answers-btn" class="btn btn-danger primary-font">Wrong </button>
                        <button id="correct-answers-btn" class="btn btn-success primary-font">Correct </button>
                        <button id="incomplete-answers-btn" class="btn btn-warning primary-font">Incomplete </button>

                    </div>

                </div>
                <div id="detailed-results"></div>
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4">
                    <button id="prev-button" class="btn btn-info bg-white" disabled><i class="bi bi-arrow-left text-info"></i> </button>
                    <div id="pagination" class="pagination d-flex flex-row justify-content-center page-link shadow flex-wrap"></div>
                    <button id="next-button" class="btn btn-info bg-white"><i class="bi bi-arrow-right text-info"></i></button>
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
                        src="../../../images/JKT-logo.jpg"
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

    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const results = JSON.parse(localStorage.getItem("quizResults"));
            const detailedResultsContainer = document.getElementById("detailed-results");
            const prevButton = document.getElementById("prev-button");
            const nextButton = document.getElementById("next-button");
            const paginationContainer = document.getElementById("pagination");
            const wrongAnswersBtn = document.getElementById("wrong-answers-btn");
            const correctAnswersBtn = document.getElementById("correct-answers-btn");
            const incompleteAnswersBtn = document.getElementById("incomplete-answers-btn");
            const allAnswersBtn = document.getElementById("all-answers-btn");
            const buttons = document.querySelectorAll(".btn-group button");
            let currentPage = 1;
            const questionsPerPage = 6;
            const pagesPerGroup = 8;
            let currentGroup = 1;

            // Default filteredResults
            let filteredResults = results.map(result => {
                if (!result.userAnswer || result.userAnswer.trim() === "") {
                    result.status = "UNANSWERED";
                }
                return result;
            });

            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    buttons.forEach(btn => btn.classList.remove("active"));
                    this.classList.add("active");


                    setTimeout(() => {
                        detailedResultsContainer.classList.remove("animate__fadeOut");
                        detailedResultsContainer.classList.add("animate__fadeIn");
                    }, 200);
                });
            });

            function displayPage(page, filteredResultsArray = results) {
                detailedResultsContainer.innerHTML = "";

                if (filteredResultsArray.length === 0) {
                    detailedResultsContainer.innerHTML = "<h4 class='text-white my-5 text-center'>No results to display.</h4>";
                    paginationContainer.innerHTML = ""; // Clear pagination if no results
                    prevButton.disabled = true;
                    nextButton.disabled = true;
                    return; // Stop further processing
                }

                const start = (page - 1) * questionsPerPage;
                const end = start + questionsPerPage;
                const pageResults = filteredResultsArray.slice(start, end);

                pageResults.forEach(result => {
                    const statusClass =
                        result.status === "correct" ? "text-success" :
                        result.status === "incorrect" ? "text-danger" :
                        "text-warning";

                    // Handle "Your Answer" color based on the status
                    const userAnswerText = result.userAnswer && result.userAnswer.startsWith("img/") ?
                        `<img src="${result.userAnswer}" alt="Your Answer Image" class="mw-100 h-auto" />` :
                        `<span class="${statusClass}">${result.userAnswer || "No Answer Selected"}</span>`;

                    // Handle "Correct Answer" visibility based on filter
                    const correctAnswerText = result.correctAnswer && result.correctAnswer.startsWith("img/") ?
                        `<img src="${result.correctAnswer}" alt="Correct Answer Image" class="mw-100 h-auto" />` :
                        result.correctAnswer;

                    const resultCard = document.createElement("div");
                    resultCard.className = "p-4 border rounded shadow-sm bg-white mb-4 animate__animated animate__fadeInUp";
                    resultCard.innerHTML = `
                <strong><p>Q${result.questionNumber}: ${result.question}</p></strong>
                ${result.image ? `<img src="${result.image}" alt="Question Image" class="img-fluid rounded mb-3" />` : ""}
                <p>Your Answer: ${userAnswerText}</p>
                ${result.status !== "correct" ? `<p>Correct Answer: <span class="text-success">${correctAnswerText}</span></p>` : ""}
                <p>Status: <span class="${statusClass} text-uppercase">${result.status}</span></p>
            `;

                    detailedResultsContainer.appendChild(resultCard);

                });

                updatePaginationLinks(filteredResultsArray);
                updatePaginationButtons(filteredResultsArray);
            }

            function updatePaginationLinks(filteredResultsArray) {
                paginationContainer.innerHTML = "";
                const totalFilteredPages = Math.ceil(filteredResultsArray.length / questionsPerPage);

                const startPage = (currentGroup - 1) * pagesPerGroup + 1;
                const endPage = Math.min(currentGroup * pagesPerGroup, totalFilteredPages);

                for (let i = startPage; i <= endPage; i++) {
                    const pageLink = document.createElement("button");
                    pageLink.textContent = i;
                    pageLink.className = `page-link ${i === currentPage ? "active btn-primary text-white" : ""}`;
                    pageLink.addEventListener("click", () => {
                        currentPage = i;
                        displayPage(currentPage, filteredResults);

                        window.scrollTo({
                            top: 0,
                            behavior: "smooth"
                        });
                    });
                    paginationContainer.appendChild(pageLink);
                }
            }

            function updatePaginationButtons(filteredResultsArray) {
                const totalFilteredPages = Math.ceil(filteredResultsArray.length / questionsPerPage);
                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage === totalFilteredPages;
            }

            prevButton.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    if (currentPage < (currentGroup - 1) * pagesPerGroup + 1) {
                        currentGroup--;
                    }
                    displayPage(currentPage, filteredResults);

                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                }
            });

            nextButton.addEventListener("click", () => {
                const totalFilteredPages = Math.ceil(filteredResults.length / questionsPerPage);
                if (currentPage < totalFilteredPages) {
                    currentPage++;
                    if (currentPage > currentGroup * pagesPerGroup) {
                        currentGroup++;
                    }
                    displayPage(currentPage, filteredResults);

                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                }
            });

            // All Answers Button
            allAnswersBtn.addEventListener("click", () => {
                filteredResults = results;
                currentPage = 1;
                currentGroup = 1;
                displayPage(currentPage, filteredResults);
            });

            // Wrong Answers Button
            wrongAnswersBtn.addEventListener("click", () => {
                filteredResults = results.filter(
                    result => result.status === "incorrect" && result.userAnswer && result.userAnswer.trim() !== ""
                );
                currentPage = 1;
                currentGroup = 1;
                displayPage(currentPage, filteredResults);
            });

            // Correct Answers Button
            correctAnswersBtn.addEventListener("click", () => {
                filteredResults = results.filter(result => result.status === "correct");
                currentPage = 1;
                currentGroup = 1;
                displayPage(currentPage, filteredResults);
            });

            // Incomplete Answers Button
            incompleteAnswersBtn.addEventListener("click", () => {
                filteredResults = results.filter(result => !result.userAnswer || result.userAnswer.trim() === "");
                filteredResults.forEach(result => {
                    result.status = "unanswered";
                });
                currentPage = 1;
                currentGroup = 1;
                displayPage(currentPage, filteredResults);
            });

            // Show all answers by default
            if (filteredResults.length > 0) {
                displayPage(currentPage, filteredResults);
            } else {
                detailedResultsContainer.innerHTML = "<h4 class='text-white my-5 text-center '>No results to display.</h4>";
            }
        });
    </script>
</body>

</html>