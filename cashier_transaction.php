<?php
session_start();
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php');
    exit();
}

// Fetch products from the database
$query = "SELECT idproduk, namaproduk, harga FROM produk";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>
    <link rel="stylesheet" href="css/paymentcss.css">
    <style>
        /* Style the select dropdown to make it look more like a spinner */
        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        /* Optional: Add a hover effect */
        select:hover, input[type="number"]:hover {
            border-color: #0056b3;
            background-color: #f1f1f1;
        }

        /* Style for the "Proceed to Payment" button */
        button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="transaction-form-container">
    <h2>Start a New Transaction</h2>

    <form action="transaction_process.php" method="POST">
        <label for="product">Select Product</label>
        <select name="product" id="product" required>
            <option value="" disabled selected>Select a product</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['idproduk'] ?>"><?= $row['namaproduk'] ?> - <?= number_format($row['harga'], 0, ',', '.') ?> IDR</option>
            <?php endwhile; ?>
        </select>

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" min="1" required>

        <button type="submit" name="submit">Proceed to Payment</button>
    </form>
</div>

</body>
</html>
