<?php
session_start();

// Check if the request method is POST and if name and price parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['price'])) {
    $productName = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']);

    // Example: Adding product to cart session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Increment quantity if product already exists in cart
    if (isset($_SESSION['cart'][$productName])) {
        $_SESSION['cart'][$productName]['pcs']++;
    } else {
        $_SESSION['cart'][$productName] = [
            'price' => $price,
            'pcs' => 1
        ];
    }

    http_response_code(200);
    echo 'Product added to cart.';
} else {
    http_response_code(400);
    echo 'Invalid request.';
}
?>
