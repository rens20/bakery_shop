<?php
// Include database configuration
require_once '../config/configuration.php';

// Fetch products from the database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl mb-4">Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $product) : ?>
                <div class="bg-white shadow-md rounded-md p-4">
                    <?php
                    // Debugging statement to check image path
                    echo "Product ID: " . $product['id'] . "<br>";
                    echo "Image Path: " . $product['image_path'] . "<br>";
                    ?>
                    <img src="<?php echo $product['image_path']; ?>" alt="product Image" class="w-full mb-2 rounded-md">
                    <h2 class="text-lg font-semibold mb-2"><?php echo $product['name']; ?></h2>
                    <p class="text-gray-700 mb-2">Price: $<?php echo $product['price']; ?></p>
                    <p class="text-gray-700 mb-2">Quantity: <?php echo $product['pcs']; ?> pcs</p>
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- this calculate -->
        <!-- <div class="mt-8">
            <h3 class="text-xl font-semibold">Total Price: $<?php echo getTotalPrice($products); ?></h3>
        </div> -->
    </div>
</body>
</html>
