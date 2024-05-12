<?php
// Define variables to avoid undefined variable warnings
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';


// Function to validate login credentials
function ValidateLogin($name,$email, $password) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
    $email = mysqli_real_escape_string($conn, $email); // Escape input for security
    $password = mysqli_real_escape_string($conn, $password);
    $name = mysqli_real_escape_string($conn, $name);

    $sql = "SELECT * FROM user WHERE email = '$email' && password = '$password' && name = '$name'";
    echo "SQL Query: $sql<br>"; // Debugging output
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    var_dump($row); // Debugging output
    return $row;
}

// Function to register a new user
function Register($email, $name, $last_name, $contact, $password) {
    // Database connection setup
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape input for security
    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $contact = mysqli_real_escape_string($conn, $contact);
    $password = mysqli_real_escape_string($conn, $password);

    // Insert user data into database
    $insert = "INSERT INTO user (name, last_name, contact, email, password, type) VALUES ('$name', '$last_name', '$contact', '$email', '$password', 'user')";
    if (mysqli_query($conn, $insert)) {
        mysqli_close($conn);
        return true; // Registration successful
    } else {
        mysqli_close($conn);
        return false; // Registration failed
    }
}
?>
