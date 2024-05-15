<?php
session_start();

// Include database configuration
require_once '../config/configuration.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $cart_id = $_POST['cart_id'];

    $delete_sql = "DELETE FROM user_cart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $cart_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Product removed from cart');</script>";
    } else {
        echo "<script>alert('Error removing product from cart');</script>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

// Redirect back to cart page
$username = isset($_GET['name']) ? $_GET['name'] : '';
header("Location: cart.php?name=" . $username);
exit();
?>
