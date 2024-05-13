

User
<?php
session_start();

// Include database configuration
require_once '../config/configuration.php';

// Fetch products from the database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$username = isset($_GET['name']) ? $_GET['name'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Include Tailwind CSS -->
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
              <h1 class="text-2xl mb-4">Welcome, <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest'; ?></h1>
            </div>
            <!-- Navigation Links -->
            <nav>
                <ul class="flex">

                    <li class="mr-6 font-bold "><a href="#">Products</a></li>
                    <li class="mr-6 font-bold"><a href="cart.php?name=<?= $username ?>">Carts</a></li>
                    <li class="mr-6 font-bold"><a href="#">Receive</a></li>




        </header>
        <hr>
    <div class="container mx-auto px-4 py-8">
        <!-- Your header code here -->
        <!-- Product list -->
        <h1 class="text-3xl font-bold mb-4">Product List</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <img src="<?= $row['image_path']; ?>" alt="Product Image" class="w-full mb-2 rounded-md">
                        <h2 class="text-xl font-bold mb-2"><?= $row['name'] ?></h2>
                        <p class="text-gray-700">Price: <?= $row['price'] ?></p>
                        <!-- Add to Cart form -->
                        <form action="cart.php?name=<?= $username ?>" method="post">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                            <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                            <button type="submit" name="add_to_cart" class="mt-2 text-white font-bold py-2 px-4 rounded ">Add to Cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
// Close database connection
mysqli_close($conn);
?>