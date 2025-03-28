<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "restaurant"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM orders ORDER BY id DESC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Cart</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['address'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . htmlspecialchars($row['cart']) . "</td>
                <td>$" . number_format($row['totalPrice'], 2) . "</td>
                <td>" . $row['created_at'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
</head>
<body>
    <h2>Your Orders</h2>
    <?php include 'fetch_orders.php'; ?>
</body>
</html>
