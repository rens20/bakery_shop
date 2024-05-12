<?php


require_once '../config/configuration.php';


$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

// Calculate total price function
function getTotalPrice($products)
{
    $total = 0;
    foreach ($products as $product) {
        $total += $product['price'] * $product['pcs'];
    }
    return $total;
}

$name = '';

// Check if name parameter exists in the URL
if (isset($_GET['name'])) {
    // Sanitize and assign the name value
    $name = htmlspecialchars($_GET['name']);
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<style>

    li:hover {
        color: #78350f;
    }

    button {
        background: #78350f;
        margin-left: 60px;
    }

    button:hover {
        background: #451a03;
    }

    hr {
        font-style: bold;
    }
</style>

<body>

    <div class="container mx-auto px-4 py-8">
        <header class="flex justify-between items-center mb-6">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../assets/image/logo.png" alt="Logo" class="h-10 mr-4">
                <h1 class="text-2xl">Your Brand</h1>
            </div>
            <!-- Navigation Links -->
            <nav>
                <ul class="flex">

                    <li class="mr-6 font-bold "><a href="#">Products</a></li>
                    <li class="mr-6 font-bold"><a href="cart.php">Carts</a></li>
                    <li class="mr-6 font-bold"><a href="#">Receive</a></li>


                </ul>
            </nav>

        </header>
        <hr>
        <h1 class="text-2xl mb-4">Welcome, <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest'; ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $product) : ?>
                <div class="bg-white shadow-md rounded-md p-4">

                    <img src="<?php echo $product['image_path']; ?>" alt="product Image" class="w-full mb-2 rounded-md">
                    <h2 class="text-lg font-semibold mb-2"><?php echo $product['name']; ?></h2>
                    <p class="text-gray-700 mb-2">Price: $<?php echo $product['price']; ?></p>
                <button type="submit" class="flex items-center justify-center text-white font-semibold py-2 px-4 rounded " onclick="addToCart('Product Name', 'Product Price')">
                            <span>Add to Cart</span>
                
</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
     <script>
        function addToCart(name, price) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('Product added to cart.');
                    } else {
                        alert('Error adding product to cart.');
                    }
                }
            };
            xhr.send('name=' + encodeURIComponent(name) + '&price=' + encodeURIComponent(price));
        }
    </script>
</body>

</html>



