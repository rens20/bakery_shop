<?php
// Include database configuration
require_once '../config/configuration.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];

    // Connect to the database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Fetch the delivered item from items_delivered table
    $sqlFetchDeliveredItem = "SELECT * FROM items_delivered WHERE id = '$itemId'";
    $result = mysqli_query($conn, $sqlFetchDeliveredItem);
    if ($result && mysqli_num_rows($result) > 0) {
        $deliveredItem = mysqli_fetch_assoc($result);
        // Process the fetched data, e.g., display or use it in further operations
        echo "Delivered Item ID: " . $deliveredItem['id'] . "<br>";
        echo "Name: " . $deliveredItem['name'] . "<br>";
        echo "Product Name: " . $deliveredItem['product_name'] . "<br>";
        echo "Product Price: " . $deliveredItem['product_price'] . "<br>";
    } else {
        echo "Item not found in delivered items!";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Invalid request!";
}
?>
