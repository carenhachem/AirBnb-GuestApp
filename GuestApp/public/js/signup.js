document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const strengthIndicator = document.getElementById("strength-indicator");
    const passwordStrengthDiv = document.getElementById("password-strength");

    passwordInput.addEventListener("input", function () {
        const value = passwordInput.value;
        let strength = "weak";

        // Show the password strength div when the user starts typing
        if (value.length > 0) {
            passwordStrengthDiv.style.display = "block";
        } else {
            passwordStrengthDiv.style.display = "none"; // Hide when the input is empty
        }

        // Check for strength (example conditions: length, uppercase, digits, special characters)
        if (
            value.length >= 8 &&
            /[A-Z]/.test(value) &&
            /[0-9]/.test(value) &&
            /[@$!%*?&#]/.test(value)
        ) {
            strength = "strong";
        } else if (value.length >= 6) {
            strength = "medium";
        }

        // Update the strength indicator text and color
        strengthIndicator.textContent = strength;
        strengthIndicator.style.color =
            strength === "strong"
                ? "green"
                : strength === "medium"
                ? "orange"
                : "red";
    });
});
