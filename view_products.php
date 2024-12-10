<?php
session_start();

// Check if the user is logged in and has 'kasir' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'kasir') {
    header('Location: login.php');
    exit;
}

// Include database connection
include('koneksi.php'); // Ensure this file contains your database connection logic

// Search functionality
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Query to get products
$query = "SELECT * FROM produk WHERE namaproduk LIKE ? ORDER BY namaproduk ASC";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchTerm%"; // Bind the search term to the query
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="css/viewproductscss.css">
</head>
<body>
    
    <div class="container">
        <h2>View Products</h2>
        
        <!-- Search bar -->
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Product Table -->
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['namaproduk']); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['stok']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination (optional, if you plan to add pagination later) -->
        <div class="pagination">
            <!-- Pagination links could go here if needed -->
        </div>
    </div>
    <button onclick="window.location.href='dashboard.php'">Go Back</button>
    
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
// Close database connection
$conn->close();
?>
