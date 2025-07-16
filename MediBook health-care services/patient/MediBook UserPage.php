<?php
session_start();
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = '';
$success = '';

// Fetch user info from session email
$user = null;
$patient_city = '';
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $user_sql = "SELECT Name,Surname, id_number,phone_number, city FROM patients WHERE Email = ?";
    $user_stmt = mysqli_prepare($conn, $user_sql);
    mysqli_stmt_bind_param($user_stmt, "s", $email);
    mysqli_stmt_execute($user_stmt);
    $user_result = mysqli_stmt_get_result($user_stmt);
    $user = mysqli_fetch_assoc($user_result);
    if ($user && isset($user['city'])) {
        $patient_city = $user['city'];
    }
}

// Fetch clinics in the same city as the patient
$clinics_in_city = [];
if ($patient_city) {
    $clinic_sql = "SELECT name FROM clinics WHERE city = ?";
    $clinic_stmt = mysqli_prepare($conn, $clinic_sql);
    mysqli_stmt_bind_param($clinic_stmt, "s", $patient_city);
    mysqli_stmt_execute($clinic_stmt);
    $clinic_result = mysqli_stmt_get_result($clinic_stmt);
    while ($row = mysqli_fetch_assoc($clinic_result)) {
        $clinics_in_city[] = $row['name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['book'])) {
    // Use session user info
    $name = $user ? $user['Name'] : '';
    $surname = $user ? $user['Surname'] : '';
    $idNumber = $user ? $user['id_number'] : '';
    $phone_number = $user ? $user['phone_number'] : '';
    $clinic = $_POST['clinic'];
    $service = $_POST['serviceType'];
    $date = $_POST['appointmentDate'];
    $time = $_POST['timeSlot'];
    $symptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : '';

    // Server-side check for slot availability
    $check_sql = "SELECT COUNT(*) as count FROM bookings WHERE Clinic_Name = ? AND date = ? AND Time_Slot = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "sss", $clinic, $date, $time);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    $check_row = mysqli_fetch_assoc($check_result);
    mysqli_stmt_close($check_stmt);

    if ($check_row['count'] >= 3) {
        $error = "Sorry, this time slot is fully booked at this clinic. Please choose another time.";
    } else {
        $sql = "INSERT INTO bookings (Name, Surname, Id_number, phone_number, Time_Slot, date, Clinic_Name, Service, Symptoms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            $error = "Prepare failed: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "sssssssss", $name, $surname, $idNumber, $phone_number, $time, $date, $clinic, $service, $symptoms);

            if (mysqli_stmt_execute($stmt)) {
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                if ($affected_rows > 0) {
                    $success = "Booked successfully! ($affected_rows row inserted)";
                } else {
                    $error = "No rows were inserted - check your data.";
                }
            } else {
                $error = "Execute failed: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

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
          <a href="Information.php" class="nav-item"
            ><i class="bx bxs-user bx-tada"></i> Update Personal Information</a
          >
          <a href="#" class="nav-item"><i class="bx bx-bot bx-tada"></i> MediBot</a>
          <a href="Appointments.php" class="nav-item"
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
              <?php
              if (!empty($error)) {
                  echo "<p class='error'>$error</p>";
              }
              if (!empty($success)) {
                  echo "<p class='success'>$success</p>";
              }
              ?>
            <h2>Book an Appointment</h2>
            <form id="appointmentForm" action=" " method="POST">
              <div class="form-group">
                <label for="clinic">Choose Clinic</label>
                <select id="clinic" name="clinic" required>
                  <option value="" disabled selected>Select a clinic</option>
                  <?php if (!empty($clinics_in_city)) {
                    foreach ($clinics_in_city as $clinic_name) {
                        echo '<option value="' . htmlspecialchars($clinic_name) . '">' . htmlspecialchars($clinic_name) . '</option>';
                    }
                  } else { ?>
                    <option value="">No clinics found in your city</option>
                  <?php } ?>
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
              <div class="form-group">
                <label for="symptoms">Symptoms (optional)</label>
                <textarea id="symptoms" name="symptoms" rows="3" maxlength="255" placeholder="Describe your symptoms (optional)"></textarea>
              </div>
              <button type="submit" name="book" class="book-btn">Submit Appointment</button>
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
