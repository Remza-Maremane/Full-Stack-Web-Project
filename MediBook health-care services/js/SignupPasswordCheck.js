const form = document.getElementById("signupForm");
form.addEventListener("submit", function (e) {
    const password = document.getElementById("password").value;
    const confirmPassword =
        document.getElementById("confirmPassword").value;
    if (password !== confirmPassword) {
        e.preventDefault();
        alert("Passwords do not match.");
    }
});