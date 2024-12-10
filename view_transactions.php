<?php
session_start();

// Check if the user is logged in and has 'kasir' role
if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'kasir') {
    header('Location: login.php');
    exit;
}

// Include database connection
include('koneksi.php');

// Search functionality
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Query to get transaction details with user information
$query = "SELECT dp.iddetailpesanan, p.namaproduk, dp.qty, ps.tanggal, ps.total, ps.status, u.username
          FROM detailpesanan dp
          JOIN pesanan ps ON dp.idpesanan = ps.idpesanan
          JOIN produk p ON dp.idproduk = p.idproduk
          JOIN user u ON ps.iduser = u.iduser
          WHERE p.namaproduk LIKE ? OR u.username LIKE ?"; // Search both product name and user name
$stmt = $conn->prepare($query);
$searchTerm = "%$searchTerm%"; // Bind the search term to the query
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
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
    <div class="container">
        <h2>Laporan Penjualan</h2>
        
        <!-- Search bar -->
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search products or users..." ">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Transaction Table -->
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Quantity</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['namaproduk']) ?></td>
                            <td><?= htmlspecialchars($row['qty']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= number_format($row['total'], 0, ',', '.') ?> IDR</td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Go Back Button -->
        <button onclick="window.location.href='dashboard.php'">Go Back</button>
    </div>
    
    <footer style="text-align: center; padding: 1.5rem; margin-top: 2rem; font-family: 'JetBrainsMono'; font-size: 0.9rem;">
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

<?php
// Close the database connection
$conn->close();
?>
