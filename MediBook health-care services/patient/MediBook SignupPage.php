<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/SignupPage.css" />
    <title>MediBook Sign Up</title>
  </head>
  <body>
    <div class="container">
      <header class="top-header">
        <div class="logo">
          <img src="../images/LOGO.png" alt="MediBook Logo" />
        </div>
        <div class="back-button">
          <a href="MediBook%20HomePage.php" role="button">
            <i class="bx bx-chevron-left bx-tada"></i> Back
          </a>
        </div>
      </header>

      <div class="signup-form">
        <img
          src="../images/LOGO.png"
          alt="MediBook Secondary Logo"
          class="secondary-logo"
        />
        <h2>Sign Up</h2>
        <p>Create your MediBook account to access healthcare services</p>

        <form method="POST" action="process_signup.php" id="signupForm">
          <div class="inputBox">
            <label for="fullName">Full Name</label>
            <input
              type="text"
              id="fullName"
              name="fullName"
              placeholder="Enter your full name"
              required
            />
            <span>Full Name</span>
          </div>

          <div class="inputBox">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Enter your email"
              required
            />
            <span>Email</span>
          </div>

          <div class="inputBox">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Create a password"
              pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,12}$"
              title="Password must be 8-12 characters, include at least one digit and one special character."
              required
            />
            <span>Password</span>
          </div>

          <div class="inputBox">
            <label for="confirmPassword">Confirm Password</label>
            <input
              type="password"
              id="confirmPassword"
              name="confirmPassword"
              placeholder="Re-enter your password"
              required
            />
            <span>Confirm Password</span>
          </div>

          <div class="inputBox">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required />
            <span>Date of Birth</span>
          </div>

          <div class="inputBox">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
              <option value="" disabled selected>Select your gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
            <span>Gender</span>
          </div>

          <div class="inputBox">
            <label for="phone">Phone Number</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              placeholder="Enter your phone number"
              pattern="[0-9]{10}"
              title="Enter a valid 10-digit phone number."
              required
            />
            <span>Phone Number</span>
          </div>

          <div class="inputBox">
            <label for="idNumber">ID Number</label>
            <input
              type="text"
              id="idNumber"
              name="idNumber"
              placeholder="Enter your ID Number"
              required
            />
            <span>ID Number</span>
          </div>

          <div class="inputBox">
            <button type="submit" class="submit-btn">Create Account</button>
          </div>

          <p class="trouble-signup">
            Already have an account?
            <a href="MediBook LoginPage.php">Sign In</a>
          </p>
        </form>

        <div class="social-signup">
          <span>Or sign up with</span>
          <a href="#" aria-label="Sign up with Google">
            <i class="bx bxl-google bx-tada"></i>
          </a>
          <a href="#" aria-label="Sign up with Apple">
            <i class="bx bxl-apple bx-tada"></i>
          </a>
        </div>

        <nav>
          <a href="mailto:support@medibook.com">support@medibook.com</a>
        </nav>
      </div>

      <footer>
        <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
      </footer>
    </div>

    <!-- Password confirmation check -->
    <script src="../js/SignupPasswordCheck.js"></script>

  </body>
</html>
