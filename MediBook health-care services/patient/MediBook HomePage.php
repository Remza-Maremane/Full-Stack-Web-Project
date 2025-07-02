<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Setup -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Fonts: Quicksand -->
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap"
      rel="stylesheet"
    />

    <!-- Boxicons Library for Icons -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/HomePage.css" />

    <title>MediBook</title>
  </head>
  <body>
    <!-- ======================== Header Section ======================== -->
    <header>
      <h1>MediBook</h1>
      <nav>
        <div class="nav-center">
          <a href="#">Home</a>
          <a href="#services">Service</a>
          <a href="#contact">Contact</a>
        </div>

        <!-- Authentication Links: PHP Ready -->
        <div class="auth-links">
          <!-- Future: Replace href with PHP backend routing if needed -->
          <a href="../patient/MediBook%20LoginPage.php" class="signup">Login</a>
          <a href="../patient/MediBook%20SignupPage.php" class="signup">Sign up</a>
        </div>
      </nav>
    </header>

    <!-- ======================== Main Content ======================== -->
    <main>
      <div class="content">
        <!-- Website Logo -->
        <img src="../images/LOGO.png" alt="MediBook Health Services Logo" class="logo" />

        <!-- Welcome Text -->
        <h2>
          Elevating community healthcare with seamless, tailored solutions.
        </h2>

        <!-- Button to Scroll to Services -->
        <a href="#services" class="learn-more" id="learnMoreBtn"
          >Discover More</a
        >
      </div>
    </main>

    <!-- ======================== Services Section ======================== -->
    <section class="scroll-container" id="services">
      <section class="services">
        <h2>Our Services</h2>

        <!-- Service Cards Container -->
        <div class="services-grid">
          <!-- Example Service Card -->
          <div class="service-card">
            <i class="bx bx-health bx-burst"></i>
            <h3>General Consultation</h3>
            <p>
              Comprehensive physical health assessments, diagnosis, and
              treatment of common conditions.
            </p>
          </div>

          <div class="service-card">
            <i class="bx bxs-injection bx-tada"></i>
            <h3>Minor Surgical Procedures</h3>
            <p>Expert wound care and suturing for optimal recovery.</p>
          </div>

          <div class="service-card">
            <i class="bx bxs-face-mask bx-tada"></i>
            <h3>Vaccinations</h3>
            <p>
              Access to essential and seasonal vaccines for your protection.
            </p>
          </div>

          <div class="service-card">
            <i class="bx bx-male-sign bx-spin"></i>
            <h3>Men's Healthcare</h3>
            <p>Specialized prostate exams and sexual health consultations.</p>
          </div>

          <div class="service-card">
            <i class="bx bx-female-sign bx-spin"></i>
            <h3>Women's Healthcare</h3>
            <p>
              Family planning, contraceptive counseling, and pregnancy testing.
            </p>
          </div>

          <div class="service-card">
            <i class="bx bxs-brain bx Tada"></i>
            <h3>Mental Healthcare</h3>
            <p>
              Screening and counseling for depression, anxiety, and other mental
              health needs.
            </p>
          </div>
        </div>
      </section>

      <!-- ======================== Learn More Section ======================== -->
      <section class="services learn-more-section">
        <h2>Learn More</h2>

        <!-- Info Cards Container -->
        <div class="info-grid">
          <div class="info-card">
            <h3>Our Mission</h3>
            <img src="../images/business-plan.png" alt="Mission Logo" class="info-logo" />
            <p>
              To simplify access to public healthcare through a seamless,
              user-friendly platform for booking appointments, securing
              referrals, and connecting with essential medical services—all in
              one place.
            </p>
          </div>

          <div class="info-card">
            <h3>Our Goal</h3>
            <img src="../images/leadership.png" alt="Goal Logo" class="info-logo" />
            <p>
              To enhance healthcare access with a streamlined digital platform,
              improving service delivery, reducing administrative burdens, and
              ensuring secure, user-friendly connections to care.
            </p>
          </div>

          <div class="info-card">
            <h3>Our Objectives</h3>
            <img src="../images/objective.png" alt="Objectives Logo" class="info-logo" />
            <p>
              To develop a secure, user-centric platform that facilitates easy
              appointment booking, efficient referrals, and timely healthcare
              services for all community members.
            </p>
          </div>
        </div>
      </section>
    </section>

    <!-- ======================== Footer Section ======================== -->
    <footer id="contact">
      <div class="footer-logo">
        <img src="../images/LOGO.png" alt="MediBook Logo" />
      </div>

      <div class="footer-content">
        <!-- Contact Information -->
        <div class="contact-info">
          <h4>Contact Us</h4>
          <p>Email: support@medibook.com</p>
          <p>Phone: +1 (123) 456-7890</p>
          <p>Address: University of Mpumalanga, Nelspruit</p>
        </div>

        <!-- Social Media Links -->
        <div class="social-links">
          <h4>Follow Us</h4>
          <a href="#" aria-label="Facebook"
            ><i class="bx bxl-facebook-circle bx-tada"></i
          ></a>
          <a href="#" aria-label="Twitter"
            ><i class="bx bxl-twitter bx-tada"></i
          ></a>
          <a href="#" aria-label="Instagram"
            ><i class="bx bxl-instagram bx-tada"></i
          ></a>
          <a href="#" aria-label="Whatsapp"
            ><i class="bx bxl-whatsapp bx-tada"></i
          ></a>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <p>© 2025 MediBook. All rights reserved.</p>
      </div>
    </footer>

    <!-- ======================== JavaScript for Smooth Scrolling ======================== -->
    <script src="../js/HomePageScrolling.js"></script>
  </body>
</html>
