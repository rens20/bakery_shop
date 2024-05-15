<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="bg-gray-100">

    <!-- Main container -->
    <div class="flex h-screen">
        
        <!-- Sidebar -->
        <div class="w-1/4 bg-blue-900 text-white p-4">
            <h2 class="text-2xl font-bold mb-4">Navigation</h2>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-blue-700">Home</a>
                </li>
                <li>
                    <!-- Link to load Product 1 details -->
                    <a href="#" data-product="Product 1" class="block px-4 py-2 rounded hover:bg-blue-700 product-link">Product 1</a>
                  <a href="#" data-product="Product-2" class="block px-4 py-2 rounded hover:bg-blue-700 product-links">count of Users</a>
                  <a href="#" data-product="Product-3" class="block px-4 py-2 rounded hover:bg-blue-700 product-link3">order of users</a>
                </li>
                <!-- Add more product links here if needed -->
            </ul>
        </div>

        <!-- Main content -->
        <div id="productContent" class="flex-1 p-8">
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
                loadProductContent(productName);
            });

            function loadProductContent(productName) {
                $.ajax({
                    url: 'admin.php',
                    type: 'GET',
                    data: { product: productName },
                    success: function(response) {
                        $('#productContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        //all_user
           $(document).ready(function() {
            $('.product-links').click(function(e) {
                e.preventDefault();
                let productName = $(this).data('product-2');
                loadProductContent(productName);
            });

            function loadProductContent(productName) {
                $.ajax({
                    url: 'all_users.php',
                    type: 'GET',
                    data: { product: productName },
                    success: function(response) {
                        $('#productContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        //order of users
         $(document).ready(function() {
            $('.product-links2').click(function(e) {
                e.preventDefault();
                let productName = $(this).data('product-3');
                loadProductContent(productName);
            });

            function loadProductContent(productName) {
                $.ajax({
                    url: 'buyer_buy.php',
                    type: 'GET',
                    data: { product: productName },
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
