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

// Start the session to access session variables
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    $userID = $_SESSION['userid'];

    // Fetch the last login time from the Session table
    $sqlLastLogin = "SELECT LoginTime FROM Session WHERE UserID = $userID ORDER BY LoginTime DESC LIMIT 1";
    $resultLastLogin = $conn->query($sqlLastLogin);

    if ($resultLastLogin && $resultLastLogin->num_rows > 0) {
        $rowLastLogin = $resultLastLogin->fetch_assoc();
        $lastLoginTime = date('Y-m-d H:i:s', strtotime($rowLastLogin['LoginTime']));
    } else {
        $lastLoginTime = "N/A";
    }
} else {
    // If not logged in, set default values
    $lastLoginTime = "N/A";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    <!-- Add jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <p class="mb-0" id="welcomeMessage">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></p>
                <p class="small" id="lastLoginMessage">Last Login: <?php echo $lastLoginTime; ?></p>
                <br>
            </div>
        </div>
    </div>
</header>

<main>
    <!-- Your main content goes here -->

    <!-- Include the AJAX script for updating the header dynamically -->
    <script>
        // Function to update the header content
        function updateHeader() {
            // AJAX request to get_last_login.php
            $.ajax({
                url: 'get_last_login.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Update the last login message
                    $('#lastLoginMessage').html('Last Login: ' + response.lastLoginTime);
                },
                error: function(error) {
                    console.error('Error fetching last login time:', error);
                }
            });
        }

        // Call the function on document ready
        $(document).ready(function() {
            updateHeader();
        });
    </script>
</main>

