<?php
session_start();
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['idpesanan'])) {
    $order_id = $_GET['idpesanan'];

    // Fetch the order details
    $query = "SELECT p.namaproduk, dp.qty, p.harga, (dp.qty * p.harga) AS total_harga 
              FROM detailpesanan dp
              JOIN produk p ON p.idproduk = dp.idproduk
              WHERE dp.idpesanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_amount = 0;
    $order_details = [];
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row['total_harga'];
        $order_details[] = $row;
    }
} else {
    echo "Order not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/paymentercss.css"
</head>
<body>

<h2>Payment for Order ID: <?= htmlspecialchars($order_id) ?></h2>

<!-- Display Order Details -->
<table class="order-details">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (IDR)</th>
            <th>Total (IDR)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order_details as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['namaproduk']) ?></td>
                <td><?= htmlspecialchars($item['qty']) ?></td>
                <td><?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><?= number_format($item['total_harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Display Total Amount -->
<p class="total-amount">Total Amount: <?= number_format($total_amount, 0, ',', '.') ?> IDR</p>

<!-- Payment Form -->
<form action="complete_payment.php" method="POST">
    <input type="hidden" name="idpesanan" value="<?= htmlspecialchars($order_id) ?>">
    <button type="submit" name="complete_payment" class="complete-payment">Complete Payment</button>
</form>

</body>
</html>
