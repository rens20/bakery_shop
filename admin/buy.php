<?php
// Include database configuration
require_once '../config/configuration.php';

// Fetch cart items from the database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Fetch all data from user_cart table
$sql = "SELECT * FROM user_cart";
$result = mysqli_query($conn, $sql);

// Check for SQL query errors
if (!$result) {
    die('SQL query error: ' . mysqli_error($conn));
}

// Check if there are any cart items
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Cart Items</title>
        <!-- Include Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
      

                <!-- Main content -->
                <div class="flex-1 p-8">
                    <h1 class="text-3xl font-bold mb-4">All Cart Items</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/6 py-2">ID</th>
                                    <th class="w-1/6 py-2">Username</th>
                                    <th class="w-1/4 py-2">Product Name</th>
                                    <th class="w-1/6 py-2">Product Price</th>
                                    <th class="w-1/6 py-2">Action</th> <!-- Added Action Column -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr class="text-gray-700">
                                        <td class="border px-4 py-2"><?= htmlspecialchars($row['id']) ?></td>
                                        <td class="border px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
                                        <td class="border px-4 py-2"><?= htmlspecialchars($row['product_name']) ?></td>
                                        <td class="border px-4 py-2"><?= htmlspecialchars($row['product_price']) ?></td>
                                        <td class="border px-4 py-2">
                                            <!-- Action Button -->
                                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" id="deliverForm<?= htmlspecialchars($row['id']) ?>">
                                                <input type="hidden" name="item_id" value="<?= htmlspecialchars($row['id']) ?>">
                                                <input type="hidden" name="username" value="<?= htmlspecialchars($row['username']) ?>">
                                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>">
                                                <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['product_price']) ?>">
                                                <button type="submit" name="deliver_button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Deliver
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php

    // Check if the Deliver button is clicked
    if (isset($_POST['deliver_button'])) {
        //$itemId = $_POST['item_id'];
        $username = $_POST['username'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];

        // Insert data into items_delivered table
        $insertQuery = "INSERT INTO items_dilivered ( username, product_name, product_price) 
                        VALUES ('$username', '$productName', '$productPrice')";
                        
        if (mysqli_query($conn, $insertQuery)) {
            // Delete item from user_cart table
            $deleteQuery = "DELETE FROM user_cart WHERE username = '$$username'";
            if (mysqli_query($conn, $deleteQuery)) {
             
            } else {
                echo "<script>alert('Error deleting item from cart: " . mysqli_error($conn) . "')</script>";
            }
        } else {
            echo "<script>alert('Error delivering item: " . mysqli_error($conn) . "')</script>";
        }
    }

} else {
    echo "No items found in the cart.";
}

// Close database connection
mysqli_close($conn);
?>
