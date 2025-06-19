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
        <form method="POST" action="login.php">
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
            <button type="submit" class="submit-btn">Sign In</button>
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
