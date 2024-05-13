<?php
// Initialize session if not already done
session_start();

// Get username from the URL parameter
$username = isset($_GET['name']) ? $_GET['name'] : '';

// Check if the user is logged in and has deleted products
if (!empty($username) && isset($_SESSION[$username.'_cart_deleted'])) {
    $deletedProducts = $_SESSION[$username.'_cart_deleted'];
    
    // Display deleted products and add buttons for accepting or deleting them
    echo '<h1>Deleted Products</h1>';
    echo '<ul>';
    foreach ($deletedProducts as $product) {
        echo '<li>' . $product['name'] . ' - $' . $product['price'] . ' <a href="accept_deleted.php?name=' . $username . '&index=' . array_search($product, $deletedProducts) . '">Accept</a> | <a href="delete_deleted.php?name=' . $username . '&index=' . array_search($product, $deletedProducts) . '">Delete</a></li>';
    }
    echo '</ul>';
} else {
    echo '<p>No deleted products found.</p>';
}
?>
