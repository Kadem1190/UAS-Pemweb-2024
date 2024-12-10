<?php
session_start();
include('koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/reportsmaincss.css"> <!-- Link to the existing CSS -->
</head>
<body>
    <div class="transaction-form-container">
        <h2>Admin Panel - View Reports</h2>&nbsp;&nbsp;

        <div style="margin-bottom: 2rem;">
            <h3>Laporan Penjualan</h3>
            <a href="laporan_penjualan.php"><button>View Details</button></a>
        </div>

        <div style="margin-bottom: 2rem;">
            <h3>Laporan Inventaris</h3>
            <a href="laporan_inventaris.php"><button>View Details</button></a>
        </div>

    </div>
    <button onclick="window.location.href='dashboard.php'">Go Back</button>&nbsp;&nbsp;
  
   
</body>
<footer style="text-align: center; padding: 1.5rem; margin-top: 2rem; color: #ffffff; font-family: 'JetBrainsMono'; font-size: 0.9rem;">
    <p style="margin-bottom: 1rem;">Kadem1190's Project 2024 - UAS Pemweb 2024 XI - RPL</p>
    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <a href="https://github.com/Kadem1190" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">GitHub</a>
        <a href="mailto:epicirongamer@gmail.com" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">Gmail</a>
        <a href="https://www.linkedin.com/in/Kadem1190" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">LinkedIn</a>
        <a href="https://discord.com/users/702156695509401691" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">Discord</a>
    </div>
</footer>
</html>
