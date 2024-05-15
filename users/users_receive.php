<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <?php
        // Define the default name if not provided in the URL
        $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Process form data
            $id = $_POST['id'];
            $username = $_POST['username'];
            $productName = $_POST['product_name'];
            $productPrice = $_POST['product_price'];

            // Example: Send a message and generate a receipt
            $message = "Your order for $productName ($productPrice) has been delivered.";

            // HTML for the receipt using Tailwind CSS classes
            $receiptHtml = "
            <div class='w-full max-w-xl mx-auto p-6 bg-white rounded-lg shadow-lg'>
                <h2 class='text-2xl font-bold mb-4'>Receipt</h2>
                <div class='mb-4'>
                    <strong>Product:</strong> $productName
                </div>
                <div class='mb-4'>
                    <strong>Price:</strong> $productPrice
                </div>
                <div class='mb-4'>
                    <strong>Customer:</strong> $username
                </div>
                <div class='mb-4'>
                    <strong>Order ID:</strong> $id
                </div>
                <!-- You can add more details as needed -->
            </div>
            ";

            // Display the message and receipt
            echo "
            <div class='w-full max-w-xl mx-auto p-6 bg-white rounded-lg shadow-lg'>
                <h2 class='text-xl font-semibold mb-4'>Message:</h2>
                <p class='mb-4'>$message</p>
            </div>
            $receiptHtml
            <a href='index.html' class='block text-center mt-8 text-blue-600 hover:underline'>Back to Home</a>
            ";
        } else {
            // Display the form
            echo "
            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?name=$name' method='POST' class='w-full max-w-lg mx-auto'>
                <input type='hidden' name='id' <!-- Example ID -->
                <input type='hidden' name='username' value='$name'>
                <input type='hidden' name='product_name'  <!-- Example product name -->
                <input type='hidden' name='product_price'  <!-- Example product price -->
                <button type='submit' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>
                    Place Order
                </button>
            </form>
            ";
        }
        ?>
    </div>
</body>
</html>
