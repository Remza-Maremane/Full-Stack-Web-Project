<?php
session_start();
include '../config.php';

if (!isset($_SESSION['clinicID']) || !isset($_SESSION['clinic_name'])) {
    header('Location: Login.php');
    exit();
}
$clinicName = $_SESSION['clinic_name'];
$today = date('Y-m-d');

// Fetch today's appointments for this clinic
$appointments = [];
$appt_sql = "SELECT * FROM bookings WHERE Clinic_Name = ? AND date = ? ORDER BY Time_Slot ASC";
$appt_stmt = mysqli_prepare($conn, $appt_sql);
mysqli_stmt_bind_param($appt_stmt, "ss", $clinicName, $today);
mysqli_stmt_execute($appt_stmt);
$appt_result = mysqli_stmt_get_result($appt_stmt);
while ($row = mysqli_fetch_assoc($appt_result)) {
    $appointments[] = $row;
}

// PDF download logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_pdf'])) {
    require_once('../fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage('L');
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,"Today's Appointments for $clinicName ($today)",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(30,10,'Name',1);
    $pdf->Cell(30,10,'Surname',1);
    $pdf->Cell(30,10,'ID Number',1);
    $pdf->Cell(30,10,'Phone',1);
    $pdf->Cell(30,10,'Service',1);
    $pdf->Cell(25,10,'Time',1);
    $pdf->Cell(40,10,'Symptoms',1);
    $pdf->Cell(35,10,'Created',1);
    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    foreach ($appointments as $appt) {
        $pdf->Cell(30,10,$appt['Name'],1);
        $pdf->Cell(30,10,$appt['Surname'],1);
        $pdf->Cell(30,10,$appt['Id_number'],1);
        $pdf->Cell(30,10,$appt['phone_number'],1);
        $pdf->Cell(30,10,$appt['Service'],1);
        $pdf->Cell(25,10,$appt['Time_Slot'],1);
        $pdf->Cell(40,10,$appt['Symptoms'],1);
        $pdf->Cell(35,10,$appt['created_date'],1);
        $pdf->Ln();
    }
    $pdf->Output('D',"Appointments_$today.pdf");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/Appointments.css" />
    <title>Today's Appointments | MediBook</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="logo">
                <img src="../images/LOGO.png" alt="MediBook Logo" />
            </div>
            <nav class="main-nav">
                <a href="Home.php">Dashboard</a>
                <a href="Appointment.php">All Appointments</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="user-section">
                <span class="user-name"><i class='bx bxs-building'></i> <?php echo htmlspecialchars($clinicName); ?></span>
                <a href="Logout.php" class="logout-btn">Log Out</a>
            </div>
        </header>
        <main class="main-content">
            <h1>Today's Appointments <span style="font-size:1rem;color:#b67615;">(<?php echo count($appointments); ?>)</span></h1>
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
                                <th>Time</th>
                                <th>Symptoms</th>
                                <th>Created</th>
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
                                    <td><?php echo htmlspecialchars($appt['Time_Slot']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['Symptoms']); ?></td>
                                    <td><?php echo htmlspecialchars($appt['created_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <form method="post" action="TodayAppointment.php">
                    <input type="hidden" name="download_pdf" value="1" />
                    <button type="submit" style="margin-top:20px; background:#b67615; color:white; padding:10px 24px; border:none; border-radius:6px; font-size:1rem; cursor:pointer;">Download PDF</button>
                </form>
            <?php else: ?>
                <div class="no-appointments">
                    <i class='bx bx-calendar-x bx-tada' style='font-size:48px;color:#ba0c0c'></i>
                    <p>No appointments scheduled for today.</p>
                </div>
            <?php endif; ?>
        </main>
        <footer>
            <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
</body>
</html>
