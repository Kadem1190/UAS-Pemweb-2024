<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['iduser']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}



if (isset($_GET['id'])) {
    $iddetailpesanan = $_GET['id'];

    $query = "SELECT dp.iddetailpesanan, p.namaproduk, dp.qty, ps.tanggal, ps.total, ps.status, u.username
              FROM detailpesanan dp
              JOIN pesanan ps ON dp.idpesanan = ps.idpesanan
              JOIN produk p ON dp.idproduk = p.idproduk
              JOIN user u ON ps.iduser = u.iduser
              WHERE dp.iddetailpesanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $iddetailpesanan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Transaction not found!";
        exit;
    }

    $row = $result->fetch_assoc();
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = $_POST['qty'];
    $status = $_POST['status'];
    
    $updateQuery = "UPDATE detailpesanan dp
                    JOIN pesanan ps ON dp.idpesanan = ps.idpesanan
                    SET dp.qty = ?, ps.status = ?
                    WHERE dp.iddetailpesanan = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('isi', $qty, $status, $iddetailpesanan);
    $updateStmt->execute();

    header('Location: laporan_penjualan.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penjualan</title>
    <link rel="stylesheet" href="css/laporan.css">
</head>
<body>
    <div class="container">
        <h2>Edit Transaction Details</h2>

        <form method="POST" action="">
            <label for="namaproduk">Product Name</label>
            <input type="text" id="namaproduk" value="<?= htmlspecialchars($row['namaproduk']) ?>" disabled>

            <label for="qty">Quantity</label>
            <input type="number" id="qty" name="qty" value="<?= htmlspecialchars($row['qty']) ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="completed" <?= $row['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>

            <button type="submit">Update Transaction</button>
        </form>

        <button onclick="window.location.href='laporan_penjualan.php'">Go Back</button>
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
$conn->close();
?>
