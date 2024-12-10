<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch all users
$query = "SELECT iduser, username, role FROM user";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['iduser'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['iduser'] ?>"><button>Edit</button></a>
                        <a href="delete_user.php?id=<?= $row['iduser'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                            <button class="delete-button">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button class="go-back" onclick="window.location.href='dashboard.php'">Go Back</button>
    </div>
</body>
</html>
