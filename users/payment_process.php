<?php
session_start();

require_once '../config/configuration.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $card_name = $_POST['card_name'] ?? null;
    $card_number = $_POST['card_number'] ?? null;
    $username = isset($_GET['name']) ? $_GET['name'] : '';

    // Clear the cart
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn) {
        $sql = "DELETE FROM user_cart WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    // Redirect to cart with success message
    header('location: cart.php?name=' . urlencode($username) . '&payment=success');
    exit; // Ensure script execution stops after redirection
}
