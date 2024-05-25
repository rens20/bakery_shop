<?php
// Define variables to avoid undefined variable warnings
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';


// Function to validate login credentials
function ValidateLogin($name, $email, $password) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM user WHERE email = ? AND password = ? AND name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $row;
}

function Register($email, $name, $last_name, $contact, $password) {

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


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
