<?php
session_start();
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php');
    exit();
}

// Check if the order ID is provided
if (isset($_POST['idpesanan'])) {
    $order_id = $_POST['idpesanan'];

    // Mark the order as completed in the 'pesanan' table
    $stmt = $conn->prepare("UPDATE pesanan SET status = 'Paid' WHERE idpesanan = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();

    // Success message
    $message = "Payment successfully completed for Order ID: $order_id. Thank you for your purchase!";
} else {
    $message = "Order ID not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cssuntuksetelahpayment.css">
    <title>Payment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            text-align: center;
        }
        .message {
            padding: 20px;
            margin-top: 50px;
            background-color: #dff0d8;
            border: 1px solid #d0e9c6;
            color: #3c763d;
            font-size: 1.2rem;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Payment Status</h2>
<div class="message">
    <?= htmlspecialchars($message) ?>
</div>

<!-- Button to go back to the dashboard or orders page -->
<a href="dashboard.php" class="button">Go to Dashboard</a>

</body>
</html>
