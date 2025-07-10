<?php
session_start();
if (!isset($_SESSION['clinicID']) || !isset($_SESSION['clinic_name'])) {
    header('Location: Login.php');
    exit();
}
$clinicID = $_SESSION['clinicID'];
$clinicName = $_SESSION['clinic_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Setup -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Fonts: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />

    <!-- Boxicons Library for Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/HomePage.css" />

    <title>Clinic Dashboard | MediBook</title>
</head>
<body>
    <!-- ======================== Header Section ======================== -->
    <header>
        <h1>MediBook</h1>
        <nav>
            <div class="nav-center">
                <a href="#">Dashboard</a>
                <a href="#appointments">Appointments</a>
                <a href="#profile">Profile</a>
            </div>

            <!-- Clinic Info and Logout -->
            <div class="auth-links">
                <span style="color: #d4af37; margin-right: 20px;">
                    <i class='bx bxs-building'></i> <?php echo htmlspecialchars($clinicName); ?>
                </span>
                <a href="Logout.php" class="signup">Logout</a>
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
                Welcome to your Clinic Dashboard, <?php echo htmlspecialchars($clinicName); ?>
            </h2>

            <!-- Dashboard Stats -->
            <div style="background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 15px; margin: 20px 0;">
                <p style="margin: 10px 0;"><strong>Clinic ID:</strong> <?php echo htmlspecialchars($clinicID); ?></p>
                <p style="margin: 10px 0;"><strong>Status:</strong> Active</p>
            </div>

            <!-- Button to Scroll to Services -->
            <a href="#services" class="learn-more" id="learnMoreBtn">Manage Services</a>
        </div>
    </main>

    <!-- ======================== Services Section ======================== -->
    <section class="scroll-container" id="services">
        <section class="services">
            <h2>Clinic Management</h2>

            <!-- Service Cards Container -->
            <div class="services-grid">
                <!-- Appointments Management -->
                <div class="service-card" onclick="window.location.href='TodayAppointment.php'" style="cursor:pointer;">
                    <i class="bx bx-calendar-check bx-burst"></i>
                    <h3>Today's Schedule</h3>
                    <p>
                        View today's appointments and patient schedule. Manage time slots and patient flow efficiently.
                    </p>
                </div>

                <!-- Patient Records -->
                <div class="service-card">
                    <i class="bx bxs-user-detail bx-tada"></i>
                    <h3>Patient Records</h3>
                    <p>Access and update patient information, medical history, and treatment plans.</p>
                </div>

                <!-- Services Offered -->
                <div class="service-card">
                    <i class="bx bxs-injection bx-tada"></i>
                    <h3>Services</h3>
                    <p>
                        Manage the healthcare services your clinic offers to patients.
                    </p>
                </div>

                <!-- Clinic Profile -->
                <div class="service-card" onclick="window.location.href='Information.php'" style="cursor:pointer;">
                    <i class="bx bxs-building bx-spin"></i>
                    <h3>Clinic Profile</h3>
                    <p>Update clinic information, location details, and contact information.</p>
                </div>

                <!-- Reports & Analytics -->
                <div class="service-card">
                    <i class="bx bxs-bar-chart-alt-2 bx-spin"></i>
                    <h3>Reports</h3>
                    <p>
                        View clinic performance reports, patient statistics, and service analytics.
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
                <h4>Contact Support</h4>
                <p>Email: support@medibook.com</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Address: University of Mpumalanga, Nelspruit</p>
            </div>

            <!-- Social Media Links -->
            <div class="social-links">
                <h4>Follow Us</h4>
                <a href="#" aria-label="Facebook"><i class="bx bxl-facebook-circle bx-tada"></i></a>
                <a href="#" aria-label="Twitter"><i class="bx bxl-twitter bx-tada"></i></a>
                <a href="#" aria-label="Instagram"><i class="bx bxl-instagram bx-tada"></i></a>
                <a href="#" aria-label="Whatsapp"><i class="bx bxl-whatsapp bx-tada"></i></a>
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
