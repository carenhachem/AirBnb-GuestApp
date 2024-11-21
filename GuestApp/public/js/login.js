const eyeIcon = document.getElementById("eye-icon");
const passwordInput = document.getElementById("password");

eyeIcon.addEventListener("click", () => {
    // Toggle password visibility
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("bx-hide"); // Hide icon class
        eyeIcon.classList.add("bx-show"); // Show icon class
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("bx-show"); // Show icon class
        eyeIcon.classList.add("bx-hide"); // Hide icon class
    }
});
