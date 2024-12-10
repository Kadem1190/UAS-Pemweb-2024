<?php
include 'koneksi.php';

$query = "SELECT iduser, password FROM user";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $hashedPassword = password_hash($row['password'], PASSWORD_DEFAULT);

    $updateQuery = "UPDATE user SET password = ? WHERE iduser = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $hashedPassword, $row['iduser']);
    $stmt->execute();
}

echo "Passwords updated with hashing!";
?>
