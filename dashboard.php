<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Log out functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboardcss.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="header">
        <h1>Cashier Dashboard</h1>
    </div>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p class="welcome">You are logged in as: <strong><?php echo ucfirst($role); ?></strong></p>

        <div class="menu">
            <?php if ($role === 'admin'): ?>
                <h3>Admin Menu</h3>
                <a href="cashier_transaction.php">Process Transactions</a>
                <a href="manage_users.php">Manage Users</a>
                <a href="view_reports.php">View Reports</a>
                <a href="add_cashier.php">Add Cashier</a>
            <?php elseif ($role === 'kasir'): ?>
                <h3>Cashier Menu</h3>
                <a href="cashier_transaction.php">Process Transactions</a>
                <a href="view_products.php">View Products</a>
                <a href="view_transactions.php">View Transactions</a>
            <?php endif; ?>
        </div>

        <form method="POST">
            <button type="submit" name="logout" class="logout-btn">Log Out</button>
        </form>
    </div>
</body>
</html>
