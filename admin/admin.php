<?php
// Include database configuration
require_once '../config/configuration.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $pcs = $_POST['pcs'];

    // Validate inputs (you can add more validation as needed)
    if (empty($name) || empty($price) || empty($pcs)) {
        die('Please fill in all fields.');
    }

    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_size = $image['size'];
        $image_type = $image['type'];

        // Check file size (you can adjust the maximum size as needed)
        $max_size = 5 * 1024 * 1024; // 5 MB
        if ($image_size > $max_size) {
            die('File size exceeds maximum limit.');
        }

        // Check file type (you can restrict to specific image types if needed)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image_type, $allowed_types)) {
            die('Invalid file type. Please upload a JPEG, PNG, or GIF image.');
        }

        // Upload the file to the server
        $upload_dir = '../uploads/';
        $image_path = $upload_dir . $image_name;
        if (move_uploaded_file($image_tmp, $image_path)) {
            // File uploaded successfully, now insert product data into database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$conn) {
                die('Database connection error: ' . mysqli_connect_error());
            }

            // Escape inputs for security
            $name = mysqli_real_escape_string($conn, $name);
            $price = mysqli_real_escape_string($conn, $price);
            $pcs = mysqli_real_escape_string($conn, $pcs);
            $image_path = mysqli_real_escape_string($conn, $image_path);

            // Insert product data into database
            $sql = "INSERT INTO products (name, price, pcs, image_path) VALUES ('$name', '$price', '$pcs', '$image_path')";
            if (mysqli_query($conn, $sql)) {
                // Product added successfully, redirect to product.php
                header("Location: ../admin/admin.php");
                exit(); // Ensure script execution stops after redirection
            } else {
                echo 'Error adding product: ' . mysqli_error($conn);
            }

            // Close database connection
            mysqli_close($conn);
        } else {
            die('Error uploading file.');
        }
    } else {
        die('Please choose a file to upload.');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for specific elements */
        /* Set the background color to #78350f */
        body {
            background-color: #78350f;
        }

        /* Center the form vertically and horizontally */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
            <h1 class="text-2xl mb-4 text-center text-gray-800">Add Product</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Product Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full">
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name:</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" class="mt-1 block w-full">
                </div>

                <div>
                    <label for="pcs" class="block text-sm font-medium text-gray-700">Quantity (pcs):</label>
                    <input type="number" id="pcs" name="pcs" min="0" step="1" class="mt-1 block w-full">
                </div>

                <button type="submit" class="w-full bg-yellow-700 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                    Add Product
                </button>
            </form>
        </div>
    </div>
</body>
</html>
