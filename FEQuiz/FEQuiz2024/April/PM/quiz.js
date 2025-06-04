const quizData = [
    {
        question: "",
        image: "img/Q(1).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "e)"
    },
    {
        question: "",
        image: "img/Q(2).png",
        options: ["a) ((age ≤ 10) and (age ≥ 60)) and isMember",
            "b) ((age ≤ 10) and (age ≥ 60)) or isMember",
            "c) ((age ≤ 10) or (age ≥ 60)) and isMember",
            "d) ((age ≤ 10) or (age ≥ 60)) or isMember"],
        answer: "d) ((age ≤ 10) or (age ≥ 60)) or isMember"
    },
    {
        question: "",
        image: "img/Q(3).png",
        options: ["a) i ÷ 2 = 0",
            "b) i ÷ 2 ≠ 0",
            "c) i mod 2 = 0",
            "d) i mod 2 ≠ 0",
            "e) i = 2",
            "f) i ≠ 2"],
        answer: "c) i mod 2 = 0"
    },
    {
        question: "",
        image: "img/Q(4).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)"],
        answer: "b)"
    },
    {
        question: "",
        image: "img/Q(5).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "d)"
    },
    {
        question: "",
        image: "img/Q(6).png",
        options: ["a) rbyte & (00000001 << (i - 1))",
            "b) rbyte & (00000001 << i)",
            "c) rbyte & (00000001 << (i + 1))",
            "d) rbyte | (00000001 << (i - 1))",
            "e) rbyte | (00000001 << i)",
            "f) rbyte | (00000001 << (i + 1))"],
        answer: "a) rbyte & (00000001 << (i - 1))"
    },
    {
        question: "",
        image: "img/Q(7).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)", "i)"],
        answer: "i)"
    },
    {
        question: "",
        image: "img/Q(8).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)"],
        answer: "b)"
    },
    {
        question: "",
        image: "img/Q(9).png",
        options: ["a)", "b)", "c)", "d)"],
        answer: "b)"
    },
    {
        question: "",
        image: "img/Q(10).png",
        options: ["a)", "b)", "c)", "d)"],
        answer: "b)"
    },
    {
        question: "",
        image: "img/Q(11).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)"],
        answer: "e)"
    },
    {
        question: "",
        image: "img/Q(12).png",
        options: ["a) i < j - 1",
            "b) i < (len ÷ 2) + 1",
            "c) i < (len ÷ 2) - 1",
            "d) i < len ÷ j",
            "e) i < j ÷ 2"],
        answer: "b) i < (len ÷ 2) + 1"
    },
    {
        question: "",
        image: "img/Q(13).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)"],
        answer: "h)"
    },
    {
        question: "",
        image: "img/Q(14).png",
        options: ["a) 0.1",
            "b) 0.2",
            "c) 0.3",
            "d) 0.4",
            "e) 0.5",
            "f) 0.6",
            "g) 0.7",
            "h) 0.8",
            "i) 0.9",
            "j) 1.0"],
        answer: "i) 0.9"
    },
    {
        question: "",
        image: "img/Q(15).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)", "i)"],
        answer: "i)"
    },
    {
        question: "",
        image: "img/Q(16).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)", "g)", "h)", "i)", "j)"],
        answer: "h)"
    },
    {
        question: "",
        image: "img/Q(17).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "c)"
    },
    {
        question: "",
        image: "img/Q(18).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "f)"
    },
    {
        question: "",
        image: "img/Q(19).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "f)"
    },
    {
        question: "",
        image: "img/Q(20).png",
        options: ["a)", "b)", "c)", "d)", "e)", "f)"],
        answer: "b)"
    },




]

const quizContainer = document.getElementById("quiz-container");
const paginationContainer = document.getElementById("pagination");
const prevButton = document.getElementById("prev-button");
const nextButton = document.getElementById("next-button");
const submitButton = document.getElementById("submit");
const click = document.getElementById("click");
const a_num = document.getElementById("aq-num");
const ua_num = document.getElementById("uq-num");
const pgiNextBtn = document.getElementById("pgi-nextBtn");
const pgiLeftBtn = document.getElementById("pgi-leftBtn");

let userSelections = {};

let score = 0;
const questionsPerPage = 1;
let currentPage = 0;
const maxVisiblePages = 8;
const totalPages = Math.ceil(quizData.length / questionsPerPage); 


for (const i in quizData){
    if (userSelections[i] === undefined) {
        userSelections[i] = null; // Initialize unanswered questions
    }
}

// Helper to get URL parameter
function getURLParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Check if Random Quiz is enabled
const enableRandomQuiz = getURLParameter("enableRandomQuiz") === "1";

if (enableRandomQuiz) {
   // Fisher-Yates Shuffle 
    for (let i = quizData.length - 1; i > 0; i--) {
    const randomIndex = Math.floor(Math.random() * (i + 1)); // Generate a random index
    // Swap the elements at i and randomIndex
    [quizData[i], quizData[randomIndex]] = [quizData[randomIndex], quizData[i]];
}
} 

// Function to render questions for the current page
function renderQuestions(pageIndex) {
    quizContainer.innerHTML = ""; // Clear previous questions

    const start = pageIndex * questionsPerPage;
    const end = Math.min(start + questionsPerPage, quizData.length);
    const questionsToDisplay = quizData.slice(start, end);

    questionsToDisplay.forEach((q, index) => {
        const questionDiv = document.createElement("div");
        questionDiv.classList.add("question-block");
        questionDiv.id = `question-${start + index + 1}`; // Add unique id to each question div

        // Add question text
        const questionText = document.createElement("h3");
        questionText.innerHTML = `<strong>Q${start + index + 1}.</strong> ${q.question}`;
        questionDiv.appendChild(questionText);

        if (q.image) {
            const questionImage = document.createElement("img");
            questionImage.src = q.image;
            questionImage.alt = "Question image";
            questionImage.style.maxWidth = "100%"; // Style the image for better fit
            questionDiv.appendChild(questionImage);
        }

        // Add options
        q.options.forEach(option => {
            const label = document.createElement("label");
            label.className = "select-answer"
            label.style.display = "block";

            const input = document.createElement("input");
            input.type = "radio";
            input.name = `question${start + index}`;
            input.value = option;

            // Pre-select if user previously chose this option
            if (userSelections[start + index] === option) {
                input.checked = true;
            }

            input.addEventListener("change", () => {
                userSelections[start + index] = option; // Update user's selection
            });

            if (option.endsWith(".png") || option.endsWith(".jpg")) {
                const optionImage = document.createElement("img");
                optionImage.src = option;
                optionImage.alt = "Option image";
                optionImage.style.maxWidth = "70%";
                label.appendChild(input);
                label.appendChild(optionImage);
            } else {
                label.appendChild(input);
                label.append(option);
            }

            questionDiv.appendChild(label);
        });

        quizContainer.appendChild(questionDiv);
    });
}

// Function to render pagination links
function renderPagination() {
    paginationContainer.innerHTML = ""; // Clear previous pagination links

    const totalPages = Math.ceil(quizData.length / questionsPerPage);
    const startPage = Math.floor(currentPage / maxVisiblePages) * maxVisiblePages;
    const endPage = Math.min(startPage + maxVisiblePages, totalPages);

    for (let i = startPage; i < endPage; i++) {
        const pageLink = document.createElement("a");
        pageLink.innerText = i + 1;
        pageLink.href = "#";
        pageLink.classList.add("page-link");
        if (i === currentPage) pageLink.classList.add("active");

        if ((currentPage + 1) * questionsPerPage >= quizData.length) {
            submitButton.style.display = "block"; // Show submit button on the last page
        } else {
            submitButton.style.display = "block"; // Hide submit button otherwise
        }

        // Add click listener for pagination
        pageLink.onclick = (e) => {
            e.preventDefault(); // Prevent full reload
            currentPage = i;
            updatePaginationAndQuestions();
            // Scroll to the top of the page
            scrollToTop();
        };

        paginationContainer.appendChild(pageLink);
    }
    pgiLeftBtn.classList.toggle("disabled", startPage === 0);
    pgiNextBtn.classList.toggle("disabled", endPage >= totalPages);
}
// Event listeners for group navigation buttons
document.getElementById("pgi-nextBtn").onclick = (e) => {
    e.preventDefault();
    e.stopPropagation();
    const startPage = Math.floor(currentPage / maxVisiblePages) * maxVisiblePages;
    const endPage = Math.min(startPage + maxVisiblePages, totalPages);

    if (endPage < totalPages) {
        currentPage = endPage; // Move to the first page of the next group
        updatePaginationAndQuestions();
    }
};

document.getElementById("pgi-leftBtn").onclick = (e) => {
    e.preventDefault();
    e.stopPropagation(); // Prevent bubbling in case of other listeners
    const startPage = Math.floor(currentPage / maxVisiblePages) * maxVisiblePages;

    if (startPage > 0) {
        currentPage = startPage - maxVisiblePages; // Move to the first page of the previous group
        updatePaginationAndQuestions();
    }
    window.scrollTo({
        top: document.documentElement.scrollHeight, // Keep the current scroll position
        behavior: "instant", // No scrolling animation
    });
};
document.getElementById("pgi-nextBtn").onclick = (e) => {
    e.preventDefault(); 
    e.stopPropagation(); 

    const startPage = Math.floor(currentPage / maxVisiblePages) * maxVisiblePages;
    const endPage = Math.min(startPage + maxVisiblePages, totalPages);

    if (endPage < totalPages) {
        currentPage = endPage; 
        updatePaginationAndQuestions();
    }

    window.scrollTo({
        top: document.documentElement.scrollHeight, 
        behavior: "instant", 
    });
};
// Function to scroll to the top of the page
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth", // Smooth scrolling
    });
}

// Function to update questions and pagination state
function updatePaginationAndQuestions() {
    renderQuestions(currentPage);
    renderPagination();

    prevButton.classList.toggle("disabled", currentPage === 0);
    nextButton.classList.toggle(
        "disabled",
        currentPage === Math.ceil(quizData.length / questionsPerPage) - 1
    );
}


 // Track the currently active question

click.onclick = (e) => {
    const ua_num = document.getElementById("uq-num");
    const a_num = document.getElementById("aq-num");
    let activeQuestionIndex = null; // Initialize active question index

    ua_num.innerHTML = ""; // Clear previous content
    a_num.innerHTML = ""; // Clear previous content

    for (const i in userSelections) {
        const questionNum = parseInt(i) + 1; // Question numbers are 1-based
        const unAnswered = userSelections[i] === null; // Check if unanswered
        const boxClass = unAnswered ? "unanswered" : "answered";
        const isActive = parseInt(i) === activeQuestionIndex; // Check if this question is active

        const boxHTML = `
            <a style="display:contents" onclick="setActiveState(${i})">
                <div class="border border-2 border-info rounded shadow d-flex align-items-center justify-content-center ${boxClass} question-link ${
            isActive ? "active" : ""
        }"
                    style="
                        flex: 1 1 calc(33.33% - 50px); 
                        aspect-ratio: 1 / 1; 
                        min-width: 40px; 
                        max-width: 60px; 
                        background-color: #f8f9fa;
                        font-size: 0.8rem;
                        text-align: center;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                    ">
                    <strong>Q${questionNum}</strong>
                </div>
            </a>`;

        if (unAnswered) {
            // Add to Unanswered questions
            ua_num.innerHTML += boxHTML;
        } else {
            // Add to Answered questions
            a_num.innerHTML += boxHTML;
        }
    }
};

// Function to handle setting the active state
function setActiveState(index) {
    activeQuestionIndex = parseInt(index); // Update the active index globally
    updateActiveState(); // Update the active state in the DOM
    navigateToQuestion(index); // Navigate to the clicked question
}

// Function to update the active state in the DOM
function updateActiveState() {
    // Get all question links in the sidebar
    const allQuestionElements = document.querySelectorAll("#uq-num a div, #aq-num a div");

    allQuestionElements.forEach((element) => {
        const questionNumber = parseInt(element.textContent.replace("Q", "")) - 1; // Extract question number from text

        // Update active state based on activeQuestionIndex
        if (questionNumber === activeQuestionIndex) {
            element.classList.add("active"); // Add active class
        } else {
            element.classList.remove("active"); // Remove active class
        }
    });
}

function navigateToQuestion(questionIndex) {
    const pageIndex = Math.floor(questionIndex / questionsPerPage); // Determine the page containing the question
    // If the target question is not on the current page, update the page
    if (pageIndex !== currentPage) {
        currentPage = pageIndex;
        updatePaginationAndQuestions(); // Render the correct page
    }

    // Delay to ensure the correct page is rendered before scrolling
    setTimeout(() => {
        const questionId = `question-${parseInt(questionIndex) + 1}`; // +1 because IDs start from 1
        const questionElement = document.getElementById(questionId);
        const navHeight = document.querySelector("nav").offsetHeight; // Get the navigation bar's height

        if (questionElement) {
            // Calculate the position to scroll to, adjusting for the nav height
            const questionPosition = questionElement.getBoundingClientRect().top + window.scrollY - navHeight;

            // Scroll to the adjusted position
            window.scrollTo({
                top: questionPosition,
                behavior: "smooth", // Smooth scrolling
            });
        }
    }, 100); // Adjust delay if necessary for rendering to complete
}

// Event listener for question links
document.querySelectorAll("#uq-num a, #aq-num a").forEach((link, index) => {
    link.addEventListener("click", (e) => {
        e.preventDefault(); 
        setActiveState(index); 
    });
});


// Initial call to render the first page and pagination
updatePaginationAndQuestions();

// Previous button click
prevButton.onclick = (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (currentPage > 0) {
        currentPage--;
        updatePaginationAndQuestions();
        scrollToTop();
    }
};

// Next button click
nextButton.onclick = (e) => {
    e.preventDefault();
    const totalPages = Math.ceil(quizData.length / questionsPerPage);
    if (currentPage < totalPages - 1) {
        currentPage++;
        updatePaginationAndQuestions();
        scrollToTop();
    }
};

// Submit button click
submitButton.onclick = () => {
    // Reset score
    let score = 0;
    let results = []; // Array to store detailed results

    // Calculate the score and collect results
   // Iterate through all questions in the quiz data
    quizData.forEach((questionData, questionIndex) => {
        const selectedOption = userSelections[questionIndex]; // Get the user's selected option
        const isAnswered = selectedOption !== undefined; // Check if the question was answered
        const isCorrect = isAnswered && questionData.answer === selectedOption; // Check if the answer is correct

        // Update score if the answer is correct
        if (isCorrect) {
            score++;
        }

        // Collect results for all questions
        results.push({
            questionNumber: questionIndex + 1,  // Add question number
            question: questionData.question,
            userAnswer: isAnswered ? selectedOption : "Unanswered",
            correctAnswer: questionData.answer,
            status: isAnswered ? (isCorrect ? "correct" : "incorrect") : "unanswered",
            image: questionData.image || null,
        });
    });

    //data to result.php
    const data = {score};
    // Send data to the server using fetch
    fetch('results.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data), // Convert data to JSON
    })
        .then(response => response.text()) // Handle the response as text
        .then(result => {
            console.log('Response from PHP:', result);
        //    alert(`Server response: ${result}`);
        })
        .catch(error => {
            console.error('Error:', error);
        });


    // Pass data to the results page
    const resultsPage = "results.php";

    // Save results in local storage
    localStorage.setItem("quizResults", JSON.stringify(results));

    // Pass only essential data in the query string
    const params = new URLSearchParams({
        totalScore: score,
        totalQuestions: quizData.length,
    });
    window.location.href = `${resultsPage}?${params.toString()}`;

};

// unanswered tooltips
document.addEventListener("DOMContentLoaded", () => {
    // Get the sidebar element and the tooltip trigger element
    const offcanvasElement = document.getElementById("offcanvasWithBothOptions");
    const tooltipTrigger = document.getElementById("click");

    // Initialize tooltip manually
    let tooltipInstance = new bootstrap.Tooltip(tooltipTrigger, {
        placement: 'bottom', // Tooltip placement
    });

    // Add event listener for when the sidebar is hidden
    offcanvasElement.addEventListener("hidden.bs.offcanvas", () => {
        // Dispose the tooltip completely to reset its state
        if (tooltipInstance) {
            tooltipInstance.dispose();
            tooltipInstance = null;
        }
    });

    // Reinitialize the tooltip when the element is hovered again
    tooltipTrigger.addEventListener('mouseenter', () => {
        // Reinitialize the tooltip if it's disposed
        if (!tooltipInstance) {
            tooltipInstance = new bootstrap.Tooltip(tooltipTrigger, {
                placement: 'bottom',
            });
        }
        // Show the tooltip immediately on hover
        tooltipInstance.show();
    });
});

// scroll bar disappear
document.addEventListener("DOMContentLoaded", () => {
    const offcanvasElement = document.getElementById("offcanvasWithBothOptions");


    // Handle the sidebar open and close for scrollbar control
    offcanvasElement.addEventListener("show.bs.offcanvas", () => {
        document.body.style.overflow = "hidden"; // Hide the scrollbar when sidebar is shown
    });

    offcanvasElement.addEventListener("hidden.bs.offcanvas", () => {
        document.body.style.overflow = ""; // Reset overflow property when sidebar is hidden
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const timerDisplay = document.getElementById("timer"); // Timer element
    const timesUpModal = new bootstrap.Modal(document.getElementById("timesUpModal")); // Modal for Time's Up
    const timeLeftDisplay = document.getElementById("time-left"); // Countdown display inside modal-footer
    let totalSeconds = 1 * 60 * 60 + 40 * 60; //timer duration
    let countdownInterval; // Variable for countdown interval
    let countdownStarted = false;

    // Retrieve the enableTimer parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const enableTimer = urlParams.get('enableTimer');

    // Function to update the timer display
    function updateTimerDisplay() {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        // Update the timer element
        timerDisplay.textContent = `${hours.toString().padStart(2, "0")}:${minutes
        .toString()
        .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
    }

    // Function to trigger the red color and twinkle effect
    function triggerRedEffect() {
        timerDisplay.style.color = "red"; // Change the timer color to red
    }
    // Function to trigger the red color and twinkle effect
    function triggerRedTwinkleEffect() {
        timerDisplay.style.color = "red"; // Change the timer color to red
        timerDisplay.classList.add("twinkle"); // Add twinkle class
    }

    // Start the timer
    function startTimer() {
        const timerInterval = setInterval(() => {
            if (totalSeconds > 0) {
                totalSeconds--;
                updateTimerDisplay();
                if (totalSeconds === 900) {
                    triggerRedEffect();
                } else if (totalSeconds === 300) {
                    triggerRedTwinkleEffect();
                }
            } else {
                clearInterval(timerInterval); // Stop the timer
                timesUpModal.show(); // Show "Time's up" modal
                startCountdownBeforeSubmit(); // Start the countdown before submission
            }
        }, 1000); // Update every second
    }

    // Countdown logic for Time's Up modal
    function startCountdownBeforeSubmit() {
        let countdown = 5;
        timeLeftDisplay.textContent = `In ${countdown} seconds, your score will be calculated`;

        countdownInterval = setInterval(() => {
            countdown--;
            timeLeftDisplay.textContent = `In ${countdown} seconds, your score will be calculated`;

            if (countdown <= 0) {
                clearInterval(countdownInterval); // Clear interval
                submitButton.click(); // Automatically submit quiz after countdown
            }
        }, 1000);
    }
    // Check if timer should be enabled based on the URL parameter
    if (enableTimer === "1") {
        // Show the timer and start it if enabled
        timerDisplay.style.display = "block"; // Make the timer visible
        updateTimerDisplay(); // Update the timer display initially
        startTimer(); // Start the timer countdown
    } else {
        // Hide the timer if not enabled
        timerDisplay.style.display = "none"; // Hide the timer
        countdownStarted = false;
    }
});

//modal box to leave from the exam page
document.addEventListener("DOMContentLoaded", () => {
    const leavePageModal = new bootstrap.Modal(document.getElementById("leavePageModal"));
    const confirmLeaveButton = document.getElementById("confirmLeaveButton");

    // Event listener for nav links
    document.querySelectorAll("a[data-target-link]").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent default navigation
            const targetLink = link.getAttribute("data-target-link"); // Get target link

            // Set the confirmation button's href
            confirmLeaveButton.setAttribute("href", targetLink);

            // Show the confirmation modal
            leavePageModal.show();
        });
    });
});

