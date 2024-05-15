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
    <body>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-4">All Cart Items</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/4 px-4 py-2">ID</th>
                            <th class="w-1/4 px-4 py-2">Username</th>
                            <th class="w-1/4 px-4 py-2">Product Name</th>
                            <th class="w-1/4 px-4 py-2">Product Price</th>
                            <th class="w-1/4 px-4 py-2">Action</th> <!-- Added Action Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="text-gray-700">
                                <td class="border px-4 py-2"><?= $row['id'] ?></td>
                                <td class="border px-4 py-2"><?= $row['username'] ?></td>
                                <td class="border px-4 py-2"><?= $row['product_name'] ?></td>
                                <td class="border px-4 py-2"><?= $row['product_price'] ?></td>
                                <td class="border px-4 py-2">
                                    <!-- Action Button -->
                                    <button type="button" onclick="deliverItem(<?= $row['id'] ?>, '<?= $row['username'] ?>', '<?= $row['product_name'] ?>', '<?= $row['product_price'] ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Deliver
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function deliverItem(id, username, productName, productPrice) {
                // Create a new XMLHttpRequest object
                var xhttp = new XMLHttpRequest();

                // Set up the request
                xhttp.open("POST", "../users/users_receive.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // Define what happens on successful response
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Display the response (optional)
                        console.log(this.responseText);

                        // Update the UI or display a success message as needed
                        alert("Item delivered successfully!");
                    }
                };

                // Prepare the data to be sent
                var data = "id=" + id + "&username=" + encodeURIComponent(username) + "&product_name=" + encodeURIComponent(productName) + "&product_price=" + productPrice;

                // Send the request with the data
                xhttp.send(data);
            }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "No items found in the cart.";
}

// Close database connection
mysqli_close($conn);
?>
