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
    <link rel="stylesheet" href="../css/UserPage.css" />
    <title>MediBook User Page</title>
  </head>
  <body>
    <div class="container">
      <header class="top-header">
        <nav class="main-nav">
          <a href="MediBook%20HomePage.php">Home</a>
          <a href="#contact">Contact</a>
          <a href="#services">Services</a>
        </nav>
        <div class="user-section">
          <button
            class="user-icon-btn"
            onclick="toggleNav()"
            aria-expanded="false"
            aria-controls="sideNav"
          >
            <img src="../images/salina%20amani.jpeg" alt="User Profile" class="user-icon" />
          </button>
          <button class="logout-btn">Log Out</button>
        </div>
      </header>
      <div class="content">
        <nav class="side-nav" id="sideNav" aria-expanded="false">
          <a href="#" class="nav-item"
            ><i class="bx bxs-user bx-tada"></i> Update Personal Information</a
          >
          <a href="#" class="nav-item"
            ><i class="bx bx-bot bx-tada"></i> MediBot</a
          >
          <a href="#" class="nav-item"
            ><i class="bx bx-calendar-check bx-burst"></i> View Appointment</a
          >
          <a href="#" class="nav-item"
            ><i class="bx bx-map bx-tada"></i>Clinic Locator</a
          >
          <a href="#" class="nav-item"
            ><i class="bx bx-alarm-exclamation bx-tada"></i> Immediate Emergency
            Services</a
          >
        </nav>
        <div class="main-content">
          <div class="default-content" id="defaultContent">
            <h1>Your Health, Our Priority</h1>
            <p>
              Our website is dedicated to offering our community the best
              health-care services fitting for all their needs.
            </p>
            <button class="book-btn" onclick="showAppointmentForm()">
              Book Appointment
            </button>
          </div>
          <div
            class="appointment-form-container"
            id="appointmentFormContainer"
            style="display: none"
          >
            <h2>Book an Appointment</h2>
            <form
              id="appointmentForm"
              action="/api/book-appointment"
              method="POST"
            >
              <div class="form-group">
                <label for="idNumber">ID Number (13 digits)</label>
                <input
                  type="text"
                  id="idNumber"
                  name="idNumber"
                  maxlength="13"
                  pattern="[0-9]{13}"
                  required
                  aria-describedby="idNumberError"
                />
                <span id="idNumberError" class="error-message"
                  >Please enter a valid 13-digit ID number.</span
                >
              </div>
              <div class="form-group">
                <label for="clinic">Choose Clinic</label>
                <select id="clinic" name="clinic" required>
                  <option value="" disabled selected>Select a clinic</option>
                  <option value="city-health">City Health Clinic</option>
                  <option value="medicare">MediCare Center</option>
                  <option value="sunrise">Sunrise Medical Hub</option>
                  <option value="hope">Hope Wellness Clinic</option>
                </select>
              </div>
              <div class="form-group">
                <label for="serviceType">Service Type</label>
                <select id="serviceType" name="serviceType" required>
                  <option value="" disabled selected>Select a service</option>
                  <option value="checkup">General Checkup</option>
                  <option value="vaccination">Vaccination</option>
                  <option value="consultation">Specialist Consultation</option>
                  <option value="lab-test">Lab Test</option>
                </select>
              </div>
              <div class="form-group">
                <label for="appointmentDate">Appointment Date</label>
                <input
                  type="date"
                  id="appointmentDate"
                  name="appointmentDate"
                  required
                  aria-describedby="dateError"
                />
                <span id="dateError" class="error-message"
                  >Please select a future date.</span
                >
              </div>
              <div class="form-group">
                <label for="timeSlot">Time Slot</label>
                <select id="timeSlot" name="timeSlot" required>
                  <option value="" disabled selected>Select a time slot</option>
                </select>
              </div>
              <button type="submit" class="book-btn">Submit Appointment</button>
              <button
                type="button"
                class="cancel-btn"
                onclick="hideAppointmentForm()"
              >
                Cancel
              </button>
            </form>
          </div>
        </div>
      </div>
      <footer>
        <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
      </footer>
    </div>

    <script src="../js/UserPage.js"></script>

  </body>
</html>
