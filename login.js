// scroll bar disappear
document.addEventListener("show.bs.modal", () => {
    document.body.classList.add("modal-open");
});
document.addEventListener("hidden.bs.modal", () => {
    document.body.classList.remove("modal-open");
});

// register
document.addEventListener("DOMContentLoaded", function() {
    const togglePasswordIcon = document.getElementById("togglePasswordIcon");
    const passwordInput = document.getElementById("register-password");

    togglePasswordIcon.addEventListener("click", function() {
        const isPasswordHidden = passwordInput.type === "password";
        passwordInput.type = isPasswordHidden ? "text" : "password";
        togglePasswordIcon.classList.toggle("fa-eye-slash", !isPasswordHidden);
        togglePasswordIcon.classList.toggle("fa-eye", isPasswordHidden);
    });
});

// login
document.addEventListener("DOMContentLoaded", function() {
    const togglePasswordIcon = document.getElementById("togglePasswordIcon");
    const passwordInput = document.getElementById("login-password");

    togglePasswordIcon.addEventListener("click", function() {
        const isPasswordHidden = passwordInput.type === "password";
        passwordInput.type = isPasswordHidden ? "text" : "password";
        togglePasswordIcon.classList.toggle("fa-eye-slash", !isPasswordHidden);
        togglePasswordIcon.classList.toggle("fa-eye", isPasswordHidden);
    });
});

// forget password error message appear
document.getElementById("forget-submitBtn").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent form from submitting normally

    const emailInput = document.getElementById("floatingInput");
    const errorMessage = document.getElementById("forget-errorMessage");
    const formData = new FormData();
    formData.append("forget-email", emailInput.value);

    fetch("", { // Submitting to the same PHP page
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Successful case: Redirect to the reset password page
                window.location.href = "resetPassword.php?user_id=" + data.user_id;
            } else {
                // Display server-side error
                errorMessage.textContent = data.error;
                emailInput.classList.add("is-invalid");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});
// forget password form  "Close" button to reset the form
document.getElementById("close-btn").addEventListener("click", function() {
    const form = document.getElementById("emailInput");
    const emailInput = document.getElementById("floatingInput");
    const errorMessage = document.getElementById("forget-errorMessage");

    // Reset the form fields and remove validation errors
    form.reset();
    emailInput.classList.remove("is-invalid");
    errorMessage.textContent = ''; // Clear the error message
});
// Reset the form when the page is loaded
window.onload = function() {
    document.getElementById('register-form').reset();
};



