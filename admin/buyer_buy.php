<?php
session_start();

// Include database configuration
require_once '../config/configuration.php';

// Validate user authentication
if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Retrieve user's purchases with status "Pay Now"
$sql = "SELECT * FROM user_purchases WHERE user_id = ? AND status = 'Pay Now'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display purchases in HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Purchases</title>
    <!-- Include Tailwind CSS or your preferred CSS framework -->
</head>
<body>
    <h1>User Purchases</h1>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= $row['product_price'] ?></td>
                    <td><?= $row['purchase_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
