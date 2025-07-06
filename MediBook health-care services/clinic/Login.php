<?php
include '../config.php';
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $name = trim($_POST['name']);
    $password = $_POST['password'];

    if ($name === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        $sql = "SELECT clinicID, Password FROM clinics WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($clinicID, $hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['clinicID'] = $clinicID;
                $_SESSION['clinic_name'] = $name;
                header('Location: home.php');
                exit();
            } else {
                $error = 'Invalid name or password.';
            }
        } else {
            $error = 'Invalid name or password.';
        }
        $stmt->close();
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
    <title>Clinic Login | MediBook</title>
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
            <h2>Clinic Login</h2>
            <p>Log in to your clinic account</p>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST" action="" id="clinicLoginForm">
                <div class="inputBox">
                    <label for="name">Clinic Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter clinic name" required />
                    <span>Clinic Name</span>
                </div>
                <div class="inputBox">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required />
                    <span>Password</span>
                </div>
                <button type="submit" name="login">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>
