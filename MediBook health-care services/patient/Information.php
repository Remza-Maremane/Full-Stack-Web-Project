<?php
session_start();
include '../config.php'; // Adjust path if needed

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: MediBook LoginPage.php');
    exit();
}

$email_session = $_SESSION['email'];
$message = '';

// Fetch user info for header
$user = null;
$user_sql = "SELECT Name, Surname FROM patients WHERE Email = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param('s', $email_session);
$user_stmt->execute();
$user_stmt->bind_result($header_name, $header_surname);
$user_stmt->fetch();
$user_stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Name'];
    $surname = $_POST['Surname'];
    $id_number = $_POST['Id_number'];
    $gender = $_POST['gender'];
    $email = $_POST['Email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['Password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE patients SET Name=?, Surname=?, Id_number=?, gender=?, Email=?, phone_number=?, Password=? WHERE Email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', $name, $surname, $id_number, $gender, $email, $phone_number, $hashed_password, $email_session);
    } else {
        $sql = "UPDATE patients SET Name=?, Surname=?, Id_number=?, gender=?, Email=?, phone_number=? WHERE Email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $name, $surname, $id_number, $gender, $email, $phone_number, $email_session);
    }

    if ($stmt->execute()) {
        $message = 'Information updated successfully!';
        // If email was changed, update session
        if ($email !== $email_session) {
            $_SESSION['email'] = $email;
            $email_session = $email;
        }
    } else {
        $message = 'Error updating information.';
    }
    $stmt->close();
}

// Fetch current patient info
$sql = "SELECT Name, Surname, Id_number, gender, Email, phone_number FROM patients WHERE Email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email_session);
$stmt->execute();
$stmt->bind_result($name, $surname, $id_number, $gender, $email, $phone_number);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@450&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/UserPage.css" />
    <link rel="stylesheet" href="../css/Information.css" />
    <title>Update Personal Information | MediBook</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="logo">
                <img src="../images/LOGO.png" alt="MediBook Logo" />
            </div>
            <nav class="main-nav">
                <a href="MediBook HomePage.php">Home</a>
                <a href="MediBook UserPage.php">Dashboard</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="user-section">
                <span class="user-name"><i class='bx bxs-user'></i> <?php echo htmlspecialchars($header_name . ' ' . $header_surname); ?></span>
                <a href="MediBook LoginPage.php" class="logout-btn">Log Out</a>
            </div>
        </header>
        <main class="main-content">
            <h1>Update Personal Information</h1>
            <?php if ($message) echo '<p class="message">' . $message . '</p>'; ?>
            <div class="info-container">
                <form method="POST" class="info-form">
                    <label>Name:<input type="text" name="Name" value="<?php echo htmlspecialchars($name); ?>" required></label>
                    <label>Surname:<input type="text" name="Surname" value="<?php echo htmlspecialchars($surname); ?>" required></label>
                    <label>ID Number:<input type="text" name="Id_number" value="<?php echo htmlspecialchars($id_number); ?>" required></label>
                    <label>Gender:
                        <select name="gender" required>
                            <option value="Male" <?php if ($gender=='Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($gender=='Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if ($gender=='Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </label>
                    <label>Email:<input type="email" name="Email" value="<?php echo htmlspecialchars($email); ?>" required></label>
                    <label>Phone Number:<input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required></label>
                    <label>Password (leave blank to keep current):<input type="password" name="Password"></label>
                    <button type="submit">Update Information</button>
                </form>
            </div>
        </main>
        <footer>
            <p>© 2025 MediBook | <a href="#">Privacy Policy</a></p>
        </footer>
    </div>
</body>
</html>
