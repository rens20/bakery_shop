<?php
// Include database configuration
require_once '../config/configuration.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $price = $_POST['price'];
        $pcs = $_POST['pcs'];
        
        // Check if an image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageFileName = $_FILES['image']['name'];
            $imageTempName = $_FILES['image']['tmp_name'];
            $imageUploadPath = 'uploads/' . $imageFileName; // Upload path relative to the script
            
            // Move the uploaded image to the uploads folder
            if (move_uploaded_file($imageTempName, $imageUploadPath)) {
                // Image uploaded successfully, now insert into database
                try {
                    $stmt = $conn->prepare("INSERT INTO products (name, price, pcs, image_path) VALUES (:name, :price, :pcs, :image)");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':pcs', $pcs);
                    $stmt->bindParam(':image', $imageUploadPath);
                    $stmt->execute();
                    echo "Product added successfully.";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "No image uploaded.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 p-5 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl text-center font-bold mb-5">Add Product</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image:</label>
                <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name:</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="number" id="price" name="price" min="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="pcs" class="block text-sm font-medium text-gray-700">Quantity (pcs):</label>
                <input type="number" id="pcs" name="pcs" min="0" step="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Product</button>
        </form>
    </div>
</body>
</html>
