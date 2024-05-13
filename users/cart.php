<?php
session_start();

// Get the username from the URL parameter
$username = isset($_GET['name']) ? $_GET['name'] : '';

// Initialize cart for the current user if not yet initialized
if (!isset($_SESSION[$username.'_cart'])) {
    $_SESSION[$username.'_cart'] = [];
}

// Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';

    if ($product_id && $product_name && $product_price) {
        // Add product to the cart for the current user
        $_SESSION[$username.'_cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price
        ];
        echo '<p>Product added to your cart.</p>';
    } else {
        echo '<p>Error: Product details are incomplete.</p>';
    }
}


// Delete from Cart functionality
if (isset($_POST['delete_item'])) {
    $deleteIndex = isset($_POST['delete_index']) ? $_POST['delete_index'] : '';

    if ($deleteIndex !== '' && isset($_SESSION[$username.'_cart'][$deleteIndex])) {
        // Remove the item from the cart
        unset($_SESSION[$username.'_cart'][$deleteIndex]);
        // Reset array keys to maintain continuous indexing
        $_SESSION[$username.'_cart'] = array_values($_SESSION[$username.'_cart']);
        // Store the deleted product in 'deleted_products.php'
        $deletedProductsFile = fopen("process.php", "a");
        fwrite($deletedProductsFile, json_encode($deletedProduct) . PHP_EOL);
        fclose($deletedProductsFile);
    }
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
    <!-- Include Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-4">Your Cart</h1>
        <?php if (!empty($_SESSION[$username.'_cart']) && is_array($_SESSION[$username.'_cart'])) : ?>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-bold mb-4">Cart Items</h2>
                <ul>
                    <?php foreach ($_SESSION[$username.'_cart'] as $index => $item) : ?>
                        <li class="flex justify-between items-center py-2 border-b">
                            <span><?= $item['name'] ?></span>
                            <span>$<?= $item['price'] ?></span>
                            <form method="post" action="">
                                <input type="hidden" name="delete_index" value="<?= $index ?>">
                                <button type="submit" name="delete_item" class="text-red-500 ml-2">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 mt-4">
                <h2 class="text-xl font-bold mb-4">Total Price</h2>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION[$username.'_cart'] as $item) {
                    $totalPrice += $item['price'];
                }
                ?>
                <p class="text-lg font-semibold">Total: $<?= number_format($totalPrice, 2) ?></p>

                <!-- Credit Card Payment Form -->
                <div class="w-96 mx-auto border border-gray-400 rounded-lg">
                    <div class="w-full h-auto p-4 flex items-center border-b border-gray-400">
                        <h1 class="w-full">Credit Card</h1>
                    </div>
                    <div class="w-full h-auto p-4">
                        <form action="payment.php?name=<?= $username ?>" method="post">
                            <div class="mb-4 px-3 py-1 bg-white rounded-sm border border-gray-300 focus-within:text-gray-900 focus-within:border-gray-500">
                                <label for="cc-name" class="text-xs tracking-wide uppercase font-semibold">CARD NAME</label>
                                <input id="cc-name" type="text" name="cc-name" class="w-full h-8 focus:outline-none" placeholder="CARD NAME">
                            </div>
                            <!-- Add other credit card fields here -->
                            <button class="h-16 w-full rounded-sm bg-indigo-600 tracking-wide font-semibold text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-600">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Sweet Alert Styles -->
    <style>
        .swal2-popup {
            font-size: 1.6rem;
        }
    </style>

    <!-- Sweet Alert Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        <?php if (isset($_SESSION['payment_success'])) : ?>
            Swal.fire({
                title: 'Payment Successful!',
                text: 'Your payment was successful.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => {
                        window.location.href = 'product.php?name=<?php echo $username; ?>';
                    }, 1000); // Redirect after 4 seconds (4000 milliseconds)
                }
            });
            <?php
            // Unset the session variable after displaying the alert
            unset($_SESSION['payment_success']);
            endif;
            ?>
    });
    </script>
</body>
</html>
