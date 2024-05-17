<?php
session_start();

require_once '../config/configuration.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $card_name = $_POST['card_name'] ?? null;
    $card_number = $_POST['card_number'] ?? null;
    $username = isset($_GET['name']) ? $_GET['name'] : '';

    // Clear the cart
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn) {
        $sql = "DELETE FROM user_cart WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    // Redirect to cart with success message
    header('location: cart.php?name=' . urlencode($username));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Purchase</title>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Display SweetAlert when the page loads
        Swal.fire({
            title: 'Processing Purchase',
            text: 'Your purchase is being processed...',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            // Redirect to cart page after clicking OK
            window.location.href = 'cart.php?name=<?php echo urlencode($username); ?>';
        });
    </script>
</body>
</html>
