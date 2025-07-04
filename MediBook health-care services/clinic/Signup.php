<?php
include '../config.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $suburb = trim($_POST['suburb']);
    $city = trim($_POST['city']);
    $mental_health = isset($_POST['mental_health']) ? 1 : 0;
    $mens_health = isset($_POST['mens_health']) ? 1 : 0;
    $womens_health = isset($_POST['womens_health']) ? 1 : 0;
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($name === '' || $suburb === '' || $city === '' || $password === '' || $confirm_password === '') {
        $error = 'Please fill in all required fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check for duplicate clinic in same suburb/city
        $check_sql = "SELECT * FROM clinics WHERE name = ? AND suburb = ? AND city = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('sss', $name, $suburb, $city);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if ($check_result->num_rows > 0) {
            $error = 'A clinic with this name already exists in this suburb and city.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO clinics (name, suburb, city, mental_health, mens_health, womens_health, Password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param('sssiiis', $name, $suburb, $city, $mental_health, $mens_health, $womens_health, $hashed_password);
            if ($insert_stmt->execute()) {
                $success = 'Clinic registered successfully!';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/ClinicSignup.css" />
    <title>Clinic Signup | MediBook</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="logo" style="margin: 0 auto; display: flex; justify-content: center; align-items: center;">
                <img src="../images/LOGO.png" alt="MediBook Logo" />
            </div>
        </header>
        <div class="signup-form">
            <img src="../images/LOGO.png" alt="MediBook Secondary Logo" class="secondary-logo" />
            <h2>Register Clinic</h2>
            <p>Register your clinic to offer healthcare services on MediBook</p>
            <?php
            if (!empty($error)) echo "<p class='error'>$error</p>";
            if (!empty($success)) echo "<p class='success'>$success</p>";
            ?>
            <form method="POST" action="" id="clinicSignupForm">
                <div class="inputBox">
                    <label for="name">Clinic Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter clinic name" required />
                    <span>Clinic Name</span>
                </div>
                <div class="inputBox">
                    <label for="suburb">Suburb</label>
                    <input type="text" id="suburb" name="suburb" placeholder="Enter suburb" required />
                    <span>Suburb</span>
                </div>
                <div class="inputBox">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter city" required />
                    <span>City</span>
                </div>
                <div class="inputBox">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required />
                    <span>Password</span>
                </div>
                <div class="inputBox">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required />
                    <span>Confirm Password</span>
                </div>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="mental_health" /> Mental Health Services</label>
                    <label><input type="checkbox" name="mens_health" /> Men's Health Services</label>
                    <label><input type="checkbox" name="womens_health" /> Women's Health Services</label>
                </div>
                <button type="submit" name="register">Register Clinic</button>
            </form>
        </div>
    </div>
</body>
</html>
