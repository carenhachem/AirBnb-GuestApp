const passwordInput = document.getElementById("password");
const strengthIndicator = document.getElementById("strength-indicator");

passwordInput.addEventListener("input", () => {
    const value = passwordInput.value;
    let strength = "weak";

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

    strengthIndicator.textContent = strength;
    strengthIndicator.style.color =
        strength === "strong"
            ? "green"
            : strength === "medium"
            ? "orange"
            : "red";
});
