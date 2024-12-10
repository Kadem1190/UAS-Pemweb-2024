<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM user WHERE iduser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: manage_users.php');
    exit();
} else {
    echo "Error deleting user.";
}
?>
