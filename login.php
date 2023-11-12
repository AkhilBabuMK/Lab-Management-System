<?php
include('header.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    // Retrieve username and password from the form
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform SQL query to check login credentials
    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    // Check if a matching user is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['Password'])) {
            // Start a new session
            session_start();

            // Store user information in session variables
             $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['fullname'] = $row['FullName'];
            $_SESSION['role'] = $row['Role'];

            // Redirect to a welcome page or dashboard
            header("Location: welcome.php");
            exit();
        } else {
            echo '<div class="container mt-5 alert alert-danger">Invalid password.</div>';
        }
    } else {
        echo '<div class="container mt-5 alert alert-danger">User not found.</div>';
    }

    // Close the database connection
    $conn->close();
}

// Include footer.php
include('footer.php');
?>

