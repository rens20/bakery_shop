<?php
// Include database configuration
require_once '../config/configuration.php';

// Count the number of users signed up
try {
    $stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM user");
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set from the executed statement
    $row = $result->fetch_assoc(); // Fetch the associative array from the result set
    $totalUsers = $row['total_users']; // Get the total number of users from the array
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Users</title>
</head>
<body>
    <h1>Total Users: <?php echo $totalUsers; ?></h1>
</body>
</html>
