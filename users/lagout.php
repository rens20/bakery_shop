<?php
// Start the session
session_start();

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page as needed
    header("Location: ../index.php");
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: ../index.php");
    exit();
}
?>
