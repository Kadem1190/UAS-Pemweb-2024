<?php
session_start();
include 'koneksi.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get the user by username
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

//         echo "Entered password: $password <br>";
// echo "Hashed password from DB: " . $user['password'] . "<br>";

// if (password_verify($password, $user['password'])) {
//     echo "Password matches!";
// } else {
//     echo "Password does not match!";
// }

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['iduser'] = $user['iduser'];  
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Password salah!";
        }
        
        
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/csslogin.css">
    <title>Login Page</title>
</head>
<body>
    <div class="header">
        <h1>CV. Berkah Jaya Cashier Website</h1>
        <p>UAS Pemweb 2024 Azka Putra XI - RPL</p>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p class="register-link">Project Azka Putra 2024 • <a href="https://github.com/Kadem1190 ">GitHub Link</a></p>
        </form>
    </div>
</body>
</html>
