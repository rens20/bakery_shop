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

// Fetch cart item count
$count_sql = "SELECT COUNT(*) as count FROM user_cart WHERE username = ?";
$count_stmt = mysqli_prepare($conn, $count_sql);
mysqli_stmt_bind_param($count_stmt, "s", $username);
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$count_row = mysqli_fetch_assoc($count_result);
$cart_count = $count_row['count'];
mysqli_stmt_close($count_stmt);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ylagan's Bakery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-hero {
            background-image: url('bakery-hero.jpg');
            background-size: cover;
            background-position: center;
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
    <script>
        function toggleMenu() {
            document.getElementById('nav-links').classList.toggle('hidden');
        }
    </script>
<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="container mx-auto px-4 py-8">
           <header class="flex justify-between items-center mb-6">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../assets/image/logo.png" alt="Logo" class="h-10 mr-4">
                <h1 class="text-2xl mb-4">Welcome, <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest'; ?></h1>
            </div>
            <!-- Hamburger Button -->
            <div class="md:hidden">
                <button onclick="toggleMenu()" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Navigation Links -->
            <nav id="nav-links" class="hidden md:flex">
                <ul class="flex flex-col md:flex-row">
                    <li class="mr-6 font-bold"><a href="product.php?name=<?= $username ?>">Products</a></li>
                    <li class="mr-6 font-bold"><a href="cart.php?name=<?= $username ?>">Cart <?php echo ($cart_count > 0) ? '(' . $cart_count . ')' : ''; ?></a></li>
                    <li class="mr-6 font-bold"><a href="lagout.php?name=<?= $username ?>">LagOut</a></li>
                   <li class="mr-6 font-bold"><a href="about.php?name=<?= $username ?>">About Us</a></li>
                </ul>
            </nav>
        </header>
        <hr>
    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-8">
            <h1 class="text-4xl lg:text-6xl font-bold text-shadow mb-4">Welcome to Ylagan's Bakery Shop</h1>
            <p class="text-lg lg:text-xl">Where every bite tells a story of tradition, quality, and passion for baking.</p>
        </header>
        <section class="bg-hero bg-center bg-cover rounded-lg mb-8 py-16">
            <div class="container mx-auto px-4">
                <p class="text-black text-lg lg:text-xl text-center">
                    Established in 2024, Ylagan's Bakery Shop has been a cherished cornerstone of the community, delighting generations with our delectable array of freshly baked goods. From the crackle of our crusty artisan bread to the melt-in-your-mouth sweetness of our pastries, each creation embodies the dedication and expertise of our skilled bakers.

                </p>
            </div>
        </section>
        <main class="mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl lg:text-4xl font-bold mb-4">Our Heritage</h2>
                    <p class="text-lg lg:text-xl">
                        Rooted in a heritage of time-honored recipes passed down through the Ylagan family, our bakery is a testament to the artistry of baking perfected over decades. With a commitment to using only the finest ingredients sourced locally, we ensure that every bite is a moment of pure indulgence.

At Ylagan's, we believe in more than just satisfying hunger; we strive to create experiences that nourish the soul. Whether it's a morning ritual of freshly brewed coffee and warm croissants, a celebration marked by our custom-designed cakes, or a simple pleasure found in a buttery slice of pie, we take pride in being a part of life's memorable moments.

                    </p>
                </div>
                <div>
                    <h2 class="text-2xl lg:text-4xl font-bold mb-4">Quality Ingredients</h2>
                    <p class="text-lg lg:text-xl">
                        Beyond our dedication to crafting exceptional baked goods, Ylagan's Bakery Shop is deeply rooted in our community. We cherish the relationships we've built over the years and are committed to giving back through various initiatives, supporting local charities, and fostering a sense of togetherness.

As we continue to evolve and innovate, our commitment to quality, authenticity, and customer satisfaction remains unwavering. Whether you're a longtime patron or a first-time visitor, we invite you to experience the warmth and flavor of Ylagan's Bakery Shop – where every bite is a taste of tradition and a celebration of life's simple joys.
                    </p>
                </div>
            </div>
        </main>
        <footer class="text-center">
            <p class="text-lg lg:text-xl">Thank you for choosing Ylagan's Bakery Shop. We look forward to serving you soon!</p>
        </footer>
    </div>
</body>

</html>
