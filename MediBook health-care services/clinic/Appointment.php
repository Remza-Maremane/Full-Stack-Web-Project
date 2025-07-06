<?php
session_start();
include '../config.php';

if (!isset($_SESSION['clinicID']) || !isset($_SESSION['clinic_name'])) {
    header('Location: Login.php');
    exit();
}
$clinicName = $_SESSION['clinic_name'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $del_sql = "DELETE FROM bookings WHERE bookID = ? AND Clinic_Name = ?";
    $del_stmt = mysqli_prepare($conn, $del_sql);
    mysqli_stmt_bind_param($del_stmt, "is", $delete_id, $clinicName);
    mysqli_stmt_execute($del_stmt);
    header('Location: Appointment.php');
    exit();
}

// Handle update (reschedule) request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];
    $update_sql = "UPDATE bookings SET date = ?, Time_Slot = ? WHERE bookID = ? AND Clinic_Name = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssis", $new_date, $new_time, $update_id, $clinicName);
    mysqli_stmt_execute($update_stmt);
    header('Location: Appointment.php');
    exit();
}

// Fetch all appointments for this clinic
$appointments = [];
$appt_sql = "SELECT * FROM bookings WHERE Clinic_Name = ? ORDER BY date, Time_Slot";
$appt_stmt = mysqli_prepare($conn, $appt_sql);
mysqli_stmt_bind_param($appt_stmt, "s", $clinicName);
mysqli_stmt_execute($appt_stmt);
$appt_result = mysqli_stmt_get_result($appt_stmt);
while ($row = mysqli_fetch_assoc($appt_result)) {
    $appointments[] = $row;
}

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
    <title>Clinic Appointments | MediBook</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="logo">
                <img src="../images/LOGO.png" alt="MediBook Logo" />
            </div>
            <nav class="main-nav">
                <a href="Home.php">Dashboard</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="user-section">
                <span class="user-name"><i class='bx bxs-building'></i> <?php echo htmlspecialchars($clinicName); ?></span>
                <a href="Logout.php" class="logout-btn">Log Out</a>
            </div>
        </header>
        <main class="main-content">
            <h1>Clinic Appointments <span style="font-size:1rem;color:#b67615;">(<?php echo count($appointments); ?>)</span></h1>
            <?php if (count($appointments) > 0): ?>
                <div class="appointments-table-container">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Surname</th>
                                <th>ID Number</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Symptoms</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appt): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($appt['Name']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['Surname']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['Id_number']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['Service']); ?></td>
                                    <td>
                                        <?php if ($edit_id === intval($appt['bookID'])): ?>
                                            <form method="POST" class="update-form">
                                                <input type="hidden" name="update_id" value="<?php echo $appt['bookID']; ?>">
                                                <input type="date" name="new_date" value="<?php echo htmlspecialchars($appt['date']); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                                <select name="new_time" required>
                                                    <?php
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
                                    <td><?php echo htmlspecialchars($appt['Time_Slot']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['Symptoms']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['created_date']); ?></td>
                                    <td>
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this appointment?');" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $appt['bookID']; ?>">
                                            <button type="submit" class="delete-btn" title="Delete Appointment"><i class='bx bx-trash'></i></button>
                                        </form>
                                        <?php if ($edit_id === intval($appt['bookID'])): ?>
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
                    <p>No appointments found for your clinic.</p>
                </div>
            <?php endif; ?>
        </main>
        <footer>
            <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
</body>
</html>
