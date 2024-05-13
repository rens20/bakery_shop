<?php
session_start();

// Get the username from the URL parameter
$username = isset($_GET['name']) ? $_GET['name'] : '';

// Process payment logic (replace with actual payment processing code)

// Assuming payment is successful
// Clear the cart
$_SESSION[$username.'_cart'] = [];

// Set session variable for payment success
$_SESSION['payment_success'] = true;

// Redirect back to cart page with payment success alert
header("Location: cart.php?name=$username");
exit();
?>
