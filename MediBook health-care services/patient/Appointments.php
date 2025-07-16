<?php
session_start();
include '../config.php';

if (!isset($_SESSION['email'])) {
    header('Location: MediBook LoginPage.php');
    exit();
}

$email = $_SESSION['email'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $del_sql = "DELETE FROM bookings WHERE bookID = ?";
    $del_stmt = mysqli_prepare($conn, $del_sql);
    mysqli_stmt_bind_param($del_stmt, "i", $delete_id);
    mysqli_stmt_execute($del_stmt);
    // Optionally, check affected rows
    header('Location: Appointments.php');
    exit();
}

// Handle update (reschedule) request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];
    $update_sql = "UPDATE bookings SET date = ?, Time_Slot = ? WHERE bookID = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssi", $new_date, $new_time, $update_id);
    mysqli_stmt_execute($update_stmt);
    header('Location: Appointments.php');
    exit();
}

// Fetch user's id_number and name for filtering
$user_sql = "SELECT id_number, Name, Surname FROM patients WHERE Email = ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "s", $email);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
$user = mysqli_fetch_assoc($user_result);

$appointments = [];
if ($user) {
    $id_number = $user['id_number'];
    $name = $user['Name'];
    $surname = $user['Surname'];
    // Fetch appointments for this user (include bookID for deletion/update)
    $appt_sql = "SELECT bookID, Clinic_Name, Service, date, Time_Slot FROM bookings WHERE Id_number = ? ORDER BY date , Time_Slot ";
    $appt_stmt = mysqli_prepare($conn, $appt_sql);
    mysqli_stmt_bind_param($appt_stmt, "s", $id_number);
    mysqli_stmt_execute($appt_stmt);
    $appt_result = mysqli_stmt_get_result($appt_stmt);
    while ($row = mysqli_fetch_assoc($appt_result)) {
        $appointments[] = $row;
    }
}

// For inline update form: check if an update is requested for a specific appointment
$edit_id = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/Appointments.css" />
    <title>My Appointments | MediBook</title>

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
            <main class="main-content">
                <h1>My Appointments</h1>
                <?php if (count($appointments) > 0): ?>
                    <div class="appointments-table-container">
                        <table class="appointments-table">
                            <thead>
                                <tr>
                                    <th>Clinic</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appt['Clinic_Name']); ?></td>
                                        <td><?php echo htmlspecialchars($appt['Service']); ?></td>
                                        <td>
                                            <?php if ($edit_id === intval($appt['bookID'])): ?>
                                                <!-- Inline update form for rescheduling -->
                                                <form method="POST" class="update-form">
                                                    <input type="hidden" name="update_id" value="<?php echo $appt['bookID']; ?>">
                                                    <input type="date" name="new_date" value="<?php echo htmlspecialchars($appt['date']); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                                    <select name="new_time" required>
                                                        <?php
                                                        // Generate time slots (same as booking form)
                                                        $slots = ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"];
                                                        foreach ($slots as $slot) {
                                                            $selected = ($slot == $appt['Time_Slot']) ? 'selected' : '';
                                                            echo "<option value='$slot' $selected>$slot</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <button type="submit">Save</button>
                                                </form>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($appt['date']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($edit_id === intval($appt['bookID'])): ?>
                                                <!-- Show current time slot in form above -->
                                                <?php echo htmlspecialchars($appt['Time_Slot']); ?>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($appt['Time_Slot']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Delete button -->
                                            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this appointment?');" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="<?php echo $appt['bookID']; ?>">
                                                <button type="submit" class="delete-btn" title="Delete Appointment"><i class='bx bx-trash'></i></button>
                                            </form>
                                            <!-- Update button -->
                                            <?php if ($edit_id === intval($appt['bookID'])): ?>
                                                <!-- Cancel update button -->
                                                <form method="POST" action="" style="display:inline;">
                                                    <button type="submit" class="update-btn">Cancel</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="POST" action="" style="display:inline;">
                                                    <input type="hidden" name="edit_id" value="<?php echo $appt['bookID']; ?>">
                                                    <button type="submit" class="update-btn" title="Reschedule Appointment"><i class='bx bx-edit'></i> Update</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-appointments">
                        <i class='bx bx-calendar-x bx-tada' style='font-size:48px;color:#ba0c0c'></i>
                        <p>You have no appointments booked yet.</p>
                    </div>
                <?php endif; ?>
            </main>
        </div>
        <footer>
            <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
    <script src="../js/UserPage.js"></script>
</body>
</html>
