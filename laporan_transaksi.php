<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch total income from completed transactions
$query = "SELECT SUM(total) AS total_income FROM pesanan WHERE status = 'completed'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_income = $row['total_income'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="transaction-form-container">
        <h2>Laporan Transaksi</h2>
        <p>Total Income from Completed Transactions: <strong><?= number_format($total_income, 0, ',', '.') ?> IDR</strong></p>
    </div>
</body>
</html>
