<?php
// Start the session
include('header.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

// Display the welcome message with user information
echo '<h1>Welcome, ' . $_SESSION['fullname'] . '!</h1>';
echo '<p>Username: ' . $_SESSION['username'] . '</p>';
echo '<p>Role: ' . $_SESSION['role'] . '</p>';

// You can add more content to the welcome page based on your requirements

// Include header.php

?>

<!-- Your page-specific content goes here -->

<?php
// Include footer.php
include('footer.php');
?>

