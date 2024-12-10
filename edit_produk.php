<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'db_kasirazka';

$conn = new mysqli($host, $user, $pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product data
$sql = "SELECT * FROM produk WHERE idproduk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cssuntukeditprodukadmin.css">
    <title>Edit Produk</title>
</head>
<body>
    <div class="container">
        <h2>Edit Produk</h2>
        <form action="update_produk.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['idproduk']) ?>">
            
            <div class="input-group">
                <label for="namaproduk">Nama Produk:</label>
                <input type="text" id="namaproduk" name="namaproduk" value="<?= htmlspecialchars($product['namaproduk']) ?>" required>
            </div>

            <div class="input-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" required><?= htmlspecialchars($product['deskripsi']) ?></textarea>
            </div>

            <div class="input-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($product['harga']) ?>" required>
            </div>

            <div class="input-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($product['stok']) ?>" required>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
