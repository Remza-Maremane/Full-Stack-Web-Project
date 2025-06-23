<?php
session_start();
include '../config.php';

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = '';
$success = '';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT Name, Email, password FROM patients WHERE Email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['Name'] = $row['Name'];
            $_SESSION['email'] = $row['Email'];
            header("Location:../patient/MediBook%20UserPage.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Fonts: Quicksand -->
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap"
      rel="stylesheet"
    />

    <!-- Boxicons for icons -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

    <!-- External CSS file -->
    <link rel="stylesheet" href="../css/LoginPage.css" />

    <title>MediBook Login</title>
  </head>
  <body>
    <div class="container">
      <!-- Header -->
      <header class="top-header">
        <div class="logo">
          <img src="../images/LOGO.png" alt="MediBook Logo" />
        </div>
        <div class="back-button">
          <a href="MediBook%20HomePage.php">
            <i class="bx bx-chevron-left bx-tada"></i> Back
          </a>
        </div>
      </header>

        <?php
        if (!empty($error)) echo "<p class='error'>$error</p>";
        if (!empty($success)) echo "<p class='success'>$success</p>";
        ?>
      <!-- Login Form -->
      <div class="login-form">
        <img
          src="../images/LOGO.png"
          alt="MediBook Secondary Logo"
          class="secondary-logo"
        />
        <h2>Sign In</h2>
        <p>Enter your credentials to access MediBook</p>

        <!-- FORM START: sends data to login.php using POST method -->
        <form method="POST" action=" ">
          <!-- Email input -->
          <div class="inputBox">
            <label for="email" class="sr-only">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Enter your email"
              required
            />
            <span>Email</span>
          </div>

          <!-- Password input -->
          <div class="inputBox">
            <label for="password" class="sr-only">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Enter your password"
              required
            />
            <span>Password</span>
          </div>

          <!-- Submit Button -->
          <div class="inputBox">
            <button type="submit" name="login" class="submit-btn">Sign In</button>
          </div>

          <!-- Trouble signing in -->
          <p class="trouble-signin">
            <a href="#">Trouble signing in?</a>
          </p>
        </form>

        <!-- Social media login (non-functional placeholders) -->
        <div class="social-login">
          <span>Or sign in with</span>
          <a href="#" aria-label="Sign in with Google">
            <i class="bx bxl-google bx-tada"></i>
          </a>
          <a href="#" aria-label="Sign in with Apple">
            <i class="bx bxl-apple bx-tada"></i>
          </a>
        </div>

        <!-- Contact support -->
        <nav>
          <a href="mailto:support@medibook.com">support@medibook.com</a>
        </nav>
      </div>

      <!-- Footer -->
      <footer>
        <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
      </footer>
    </div>
  </body>
</html>
