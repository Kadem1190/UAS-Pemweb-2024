<?php
session_start();
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php');
    exit();
}

// Process the transaction
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['iduser'];
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];

    // Fetch product details
    $query = "SELECT namaproduk, harga, stok FROM produk WHERE idproduk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_name = $product['namaproduk'];
        $price = $product['harga'];
        $stock = $product['stok'];

        // Check if there's enough stock
        if ($stock >= $quantity) {
            // Insert into pesanan (order) table, don't specify idpesanan as it's auto-increment
            $total = $price * $quantity;
            $query = "INSERT INTO pesanan (iduser, total, tanggal) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('id', $user_id, $total);
            $stmt->execute();

            // Get the order ID of the newly created order
            $order_id = $stmt->insert_id;  // This gets the last inserted auto-increment ID

            // Insert into detailpesanan (order details) table
            $query = "INSERT INTO detailpesanan (idpesanan, idproduk, qty) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('iii', $order_id, $product_id, $quantity);
            $stmt->execute();

            // Update product stock
            $new_stock = $stock - $quantity;
            $query = "UPDATE produk SET stok = ? WHERE idproduk = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $new_stock, $product_id);
            $stmt->execute();

            // Redirect to the payment page
            header("Location: payment.php?idpesanan=" . $order_id);
            exit();
        } else {
            echo "Insufficient stock.";
        }
    } else {
        echo "Product not found.";
    }
}
?>
