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

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $sql = "UPDATE produk SET namaproduk = ?, deskripsi = ?, harga = ?, stok = ? WHERE idproduk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $namaproduk, $deskripsi, $harga, $stok, $id);

    if ($stmt->execute()) {
        echo "Produk berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui produk: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cssuntukeditprodukadmin.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<a href="laporan_inventaris.php">Kembali ke Laporan Inventaris</a>
