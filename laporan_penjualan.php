<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch transaction details with user information
$query = "SELECT dp.iddetailpesanan, p.namaproduk, dp.qty, ps.tanggal, ps.total, ps.status, u.username
          FROM detailpesanan dp
          JOIN pesanan ps ON dp.idpesanan = ps.idpesanan
          JOIN produk p ON dp.idproduk = p.idproduk
          JOIN user u ON ps.iduser = u.iduser";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="css/laporan.css">
</head>
<body>
    <div class="transaction-form-container">
        <h2>Laporan Penjualan</h2>
        <table border="1" width="100%">
            <tr>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>User</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['namaproduk']) ?></td>
                    <td><?= htmlspecialchars($row['qty']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>                    
                    <td><?= number_format($row['total'], 0, ',', '.') ?> IDR</td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><a href="edit_penjualan.php?id=<?= $row['iddetailpesanan'] ?>"><button>Edit</button></a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <button onclick="window.location.href='view_reports.php'">Go Back</button>&nbsp;&nbsp;
    
    <footer style="text-align: center; padding: 1.5rem; background-color: #f4f4f4; margin-top: 2rem; font-family: 'JetBrainsMono'; font-size: 0.9rem;">
        <p style="margin-bottom: 1rem; color: #333;">Kadem1190's Project 2024 - UAS Pemweb 2024 XI - RPL</p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="https://github.com/Kadem1190" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">GitHub</a>
            <a href="mailto:epicirongamer@gmail.com" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">Gmail</a>
            <a href="https://www.linkedin.com/in/Kadem1190" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">LinkedIn</a>
            <a href="https://discord.com/users/YOUR_DISCORD_ID" target="_blank" style="text-decoration: none; background-color: #5865fa; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; transition: background-color 0.3s;">Discord</a>
        </div>
    </footer>
</body>
</html>
