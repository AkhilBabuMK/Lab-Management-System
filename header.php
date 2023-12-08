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
<head c>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Management System</title>
    <!-- Add your stylesheet links, meta tags, or other head elements here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your JavaScript links or other head elements here -->
    <!-- For example, you can add Bootstrap's JavaScript and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<header class="container-fluid bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-white">Lab Management System</h1>
            </div>
            <div class="col-md-6 text-right">
                <!-- Add your login information or any other right-aligned content here -->
                <p class="mb-0">Welcome,  </p>
                <p class="small">Last Login: [Date & Time]</p>
                
                
            <br>
            </div>
            
        </div>
    </div>
</header>

<main>
    <!-- Your main content goes here -->

