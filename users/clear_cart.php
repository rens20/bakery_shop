<?php
session_start();

require_once '../config/configuration.php';

$username = isset($_GET['name']) ? $_GET['name'] : '';

if (!empty($username)) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    $sql = "DELETE FROM user_cart WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect back to the cart page or another page if needed. '&status=cleared')
    header('Location: cart.php?name=' . urlencode($username));
    exit;
} else {
    // Redirect back with an error message if username is not provided
    header('Location: cart.php?status=error');
    exit;
}
?>
