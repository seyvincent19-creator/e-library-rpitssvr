const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const eyeIcon = document.getElementById("eyeIcon");

// បង្ហាញ/លាក់ icon eye តាមការវាយអក្សរ
passwordInput.addEventListener("input", function () {
    if (passwordInput.value.length > 0) {
        togglePassword.style.display = "block"; // បង្ហាញ icon
    } else {
        togglePassword.style.display = "none"; // លាក់ icon
        passwordInput.setAttribute("type", "password"); // ត្រឡប់ទៅ password
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
});

// ប្ដូរបង្ហាញ/លាក់ password
togglePassword.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    if (type === "password") {
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
});
