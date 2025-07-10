<?php
session_start();
include '../config.php';

if (!isset($_SESSION['clinicID']) || !isset($_SESSION['clinic_name'])) {
    header('Location: Login.php');
    exit();
}
$clinicID = $_SESSION['clinicID'];
$message = '';

// Fetch current clinic info
$sql = "SELECT name, suburb, city, mental_health, mens_health, womens_health FROM clinics WHERE clinicID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $clinicID);
$stmt->execute();
$stmt->bind_result($name, $suburb, $city, $mental_health, $mens_health, $womens_health);
if (!($stmt->fetch())) {
    $name = $suburb = $city = '';
    $mental_health = $mens_health = $womens_health = 0;
}
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $suburb = $_POST['suburb'];
    $city = $_POST['city'];
    $mental_health = isset($_POST['mental_health']) ? 1 : 0;
    $mens_health = isset($_POST['mens_health']) ? 1 : 0;
    $womens_health = isset($_POST['womens_health']) ? 1 : 0;

    $update_sql = "UPDATE clinics SET name=?, suburb=?, city=?, mental_health=?, mens_health=?, womens_health=? WHERE clinicID=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('sssiiii', $name, $suburb, $city, $mental_health, $mens_health, $womens_health, $clinicID);
    if ($update_stmt->execute()) {
        $message = 'Information updated successfully!';
        $_SESSION['clinic_name'] = $name;
    } else {
        $message = 'Error updating information.';
    }
    $update_stmt->close();

    // Re-fetch updated clinic info
    $sql = "SELECT name, suburb, city, mental_health, mens_health, womens_health FROM clinics WHERE clinicID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clinicID);
    $stmt->execute();
    $stmt->bind_result($name, $suburb, $city, $mental_health, $mens_health, $womens_health);
    if (!($stmt->fetch())) {
        $name = $suburb = $city = '';
        $mental_health = $mens_health = $womens_health = 0;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="clinicInformation.css" />
    <title>Update Clinic Information | MediBook</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="logo">
                <img src="../images/LOGO.png" alt="MediBook Logo" />
            </div>
            <nav class="main-nav">
                <a href="Home.php">Dashboard</a>
                <a href="Appointment.php">Appointments</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="user-section">
                <span class="user-name"><i class='bx bxs-building'></i> <?php echo htmlspecialchars($name); ?></span>
                <a href="Logout.php" class="logout-btn">Log Out</a>
            </div>
        </header>
        <main class="main-content">



            <div class="info-container">
                <h1>Update Clinic Information</h1>
                <?php if ($message) echo '<p class="message">' . $message . '</p>'; ?>
                <form method="POST" class="info-form">
                    <div class="form-group">
                        <label for="name">Clinic Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="suburb">Suburb</label>
                        <input type="text" id="suburb" name="suburb" value="<?php echo htmlspecialchars($suburb); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
                    </div>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="mental_health" <?php if ($mental_health) echo 'checked'; ?> /> Mental Health Services</label>
                        <label><input type="checkbox" name="mens_health" <?php if ($mens_health) echo 'checked'; ?> /> Men's Health Services</label>
                        <label><input type="checkbox" name="womens_health" <?php if ($womens_health) echo 'checked'; ?> /> Women's Health Services</label>
                    </div>
                    <button type="submit" class="update-btn">Update Information</button>
                </form>
            </div>
        </main>
        <footer>
            <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
</body>
</html>
