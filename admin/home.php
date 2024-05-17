<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col h-screen">

    <!-- Main container -->
    <div class="flex flex-1">
        
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-blue-900 text-white p-4 flex-shrink-0">
            <h2 class="text-2xl font-bold mb-4">Navigation</h2>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-blue-700">Home</a>
                </li>
                <li>
                    <!-- Link to load Product 1 details -->
                    <a href="#" data-product="Product 1" class="block px-4 py-2 rounded hover:bg-blue-700 product-link">Send Products</a>
                </li>
                <li>
                    <a href="#" data-product="Product-2" class="block px-4 py-2 rounded hover:bg-blue-700 product-links">Count of Users and Deliver</a>
                </li>
                <li>
                    <a href="buy.php" data-product="Product-3" class="block px-4 py-2 rounded hover:bg-blue-700 product-links3">Order of Users</a>
                </li>
            </ul>
        </div>

        <!-- Main content -->
        <div id="productContent" class="flex-1 p-8 overflow-y-auto">
            <h1 class="text-4xl font-bold mb-4">Welcome to the Home Page</h1>
            <p class="mb-4">Here is some introductory content about the website.</p>

            <!-- Product Details Section will be loaded dynamically here -->
        </div>
    </div>

    <!-- JavaScript to load product details -->
    <script>
        $(document).ready(function() {
            $('.product-link').click(function(e) {
                e.preventDefault();
                let productName = $(this).data('product');
                loadProductContent('admin.php', { product: productName });
            });

            $('.product-links').click(function(e) {
                e.preventDefault();
                let productName = $(this).data('product');
                loadProductContent('all_users.php', { product: productName });
            });

            $('.product-links3').click(function(e) {
                e.preventDefault();
                let productName = $(this).data('product');
                loadProductContent('buy.php', { product: productName });
            });

            function loadProductContent(url, data) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        $('#productContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
</body>
</html>
