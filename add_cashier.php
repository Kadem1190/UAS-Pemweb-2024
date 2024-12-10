<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Password hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert cashier/admin into the database
    $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        $successMessage = "User added successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="css/addcashiercss.css">
</head>
<body>
    <div class="form-container">
        <h2>Add User</h2>

        <?php if (isset($successMessage)): ?>
            <p class="message"><?= $successMessage ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p class="message error"><?= $errorMessage ?></p>
        <?php endif; ?>

        <form method="POST" action="add_cashier.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Add User</button>
        </form>
        <button class="go-back" onclick="window.location.href='view_reports.php'">Go Back</button>
    </div>

   
</body>
<footer>
    <p style="color: white">Kadem1190's Project 2024 - UAS Pemweb 2024 XI - RPL</p>

        <div class="social-buttons">
            <a href="https://github.com/Kadem1190" target="_blank">GitHub</a>
            <a href="mailto:epicirongamer@gmail.com">Gmail</a>
            <a href="https://www.linkedin.com/in/Kadem1190" target="_blank">LinkedIn</a>
            <a href="https://discord.com/users/YOUR_DISCORD_ID" target="_blank">Discord</a>
        </div>
    </footer>
</html>
