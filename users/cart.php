<?php
session_start();

// Include database configuration
require_once '../config/configuration.php';

// Fetch cart items from the database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

$username = isset($_GET['name']) ? $_GET['name'] : '';

$sql = "SELECT * FROM user_cart WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Calculate total price
$total_price = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $total_price += $row['product_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
     <div class="container mx-auto px-4 py-8">
        <header class="flex justify-between items-center mb-6">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../assets/image/logo.png" alt="Logo" class="h-10 mr-4">
                <h1 class="text-2xl mb-4">Welcome, <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest'; ?></h1>
            </div>
            <!-- Navigation Links -->
            <nav>
                <ul class="flex">
                    <li class="mr-6 font-bold"><a href="product.php?name=<?= $username ?>">Products</a></li>
                    <li class="mr-6 font-bold"><a href="cart.php?name=<?= $username ?>">Cart</a></li>
                    <li class="mr-6 font-bold"><a href="users_receive.php?name=<?=$username ?>">Receive</a></li>
                </ul>
            </nav>
        </header>
        <hr>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Your Cart</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/3 px-4 py-2">Product Name</th>
                        <th class="w-1/3 px-4 py-2">Price</th>
                        <th class="w-1/3 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($cart_items) > 0) : ?>
                        <?php foreach ($cart_items as $item) : ?>
                            <tr class="text-gray-700">
                                <td class="border px-4 py-2"><?= htmlspecialchars($item['product_name']) ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($item['product_price']) ?></td>
                                <td class="border px-4 py-2">
                                    <!-- Remove from Cart form -->
                                    <form action="remove_from_cart.php?name=<?= urlencode($username) ?>" method="post">
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="remove_from_cart" class="bg-red-600 text-white font-bold py-2 px-4 rounded">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="2" class="text-right font-bold px-4 py-2">Total Price:</td>
                        <td class="font-bold px-4 py-2"><?= number_format($total_price, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h2 class="text-2xl font-bold my-4">Payment Method</h2>
        <form id="payment-form" action="payment_process.php?name=<?= urlencode($username) ?>" method="post">
            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-bold mb-2">Choose a payment method:</label>
                <select id="payment_method" name="payment_method" class="block w-full p-2 border rounded">
                    <option value="cod">Cash on Delivery</option>
                    <option value="credit_card">Credit Card</option>
                </select>
            </div>

            <div id="credit-card-info" class="hidden">
                <div class="mb-4">
                    <label for="card_name" class="block text-gray-700 font-bold mb-2">Name on Card:</label>
                    <input type="text" id="card_name" name="card_name" class="block w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="card_number" class="block text-gray-700 font-bold mb-2">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" class="block w-full p-2 border rounded">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Pay Now</button>
        </form>
    </div>

  <script>
    // Handle payment form submission
    document.getElementById('payment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        // Perform form validation here if needed

        // Show payment success alert
        Swal.fire({
            title: 'Payment Successful!',
            text: 'Thank you for your purchase.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            // Redirect to payment_process.php to handle the payment and cart clearing
            window.location.href = 'payment_process.php?name=<?= urlencode($username) ?>. '&payment=sucess');
        });
    });

    // Check URL parameters for status messages
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status === 'paid') {
            Swal.fire({
                title: 'Payment Completed!',
                text: 'Your payment has been processed successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect to cart.php after payment confirmation
                window.location.href = 'cart.php?name=<?= urlencode($username) ?>';
            });
        } else if (status === 'error') {
            Swal.fire({
                title: 'Error!',
                text: 'There was an error processing your payment.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
    
</script>

</body>
</html>
