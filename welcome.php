<?php
// Start the session
include('header.php');
session_start();


if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

echo '<h1>Welcome, ' . $_SESSION['fullname'] . '!</h1>';
echo '<p>Username: ' . $_SESSION['username'] . '</p>';
echo '<p>Role: ' . $_SESSION['role'] . '</p>';



// Include header.php

?>

<?php
// Include footer.php
include('footer.php');
?>

