const container = document.querySelector(".container"),
      pwShowHide = document.querySelectorAll(".showHidePw"),
      pwFields = document.querySelectorAll(".password"),
      signUp = document.querySelector(".signup-link"),
      login = document.querySelector(".login-link"),
      signupForm = document.querySelector("#signup-form"),
      loginForm = document.querySelector("#login-form");

// js code to show/hide password and change icon
pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        pwFields.forEach(pwField => {
            if (pwField.type === "password") {
                pwField.type = "text";
                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye-slash", "uil-eye");
                });
            } else {
                pwField.type = "password";
                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye", "uil-eye-slash");
                });
            }
        });
    });
});

// js code to appear signup and login form
signUp.addEventListener("click", () => {
    container.classList.add("active");
});
login.addEventListener("click", () => {
    container.classList.remove("active");
});

// Form validation
const validateForm = (form) => {
    let isValid = true;
    const username = form.querySelector("input[name='username']").value.trim();
    const password = form.querySelector("input[name='password']").value.trim();

    // Simple validation rules
    if (username === "") {
        alert("Username is required.");
        isValid = false;
    }

    if (password === "") {
        alert("Password is required.");
        isValid = false;
    } else if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        isValid = false;
    }

    return isValid;
};

signupForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Prevent the form from submitting
    if (validateForm(signupForm)) {
        // Submit the form if validation passes
        signupForm.submit();
    }
});

loginForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Prevent the form from submitting
    if (validateForm(loginForm)) {
        // Submit the form if validation passes
        loginForm.submit();
    }
});
