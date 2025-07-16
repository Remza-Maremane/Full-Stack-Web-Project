<?php
include '../config.php';

$clinic = $_GET['clinic'] ?? '';
$services = [];

if ($clinic) {
    $sql = "SELECT mental_health, mens_health, womens_health FROM clinics WHERE name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $clinic);
    $stmt->execute();
    $stmt->bind_result($mental_health, $mens_health, $womens_health);
    if ($stmt->fetch()) {
        if ($mental_health) $services[] = "Mental Health";
        if ($mens_health) $services[] = "Men's Health";
        if ($womens_health) $services[] = "Women's Health";
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($services); 