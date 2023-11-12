<?php
// Replace these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "2002";
$database = "labmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <!-- Add your stylesheet links, meta tags, or other head elements here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your JavaScript links or other head elements here -->
    <!-- For example, you can add Bootstrap's JavaScript and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<header>
    <div id="logo">
        <img src="path/to/your/logo.png" alt="Your Logo">
    </div>
    <h1>Your Website Title</h1>
    <!-- Add your navigation menu or other header content here -->
</header>

<main>
    <!-- Your main content goes here -->

