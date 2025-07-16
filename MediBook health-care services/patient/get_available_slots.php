<?php
include '../config.php';

$clinic = $_GET['clinic'] ?? '';
$date = $_GET['date'] ?? '';

$all_slots = ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"];
$available_slots = [];

if ($clinic && $date) {
    foreach ($all_slots as $slot) {
        $sql = "SELECT COUNT(*) as count FROM bookings WHERE Clinic_Name = ? AND date = ? AND Time_Slot = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $clinic, $date, $slot);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] < 3) {
            $available_slots[] = $slot;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($available_slots); 