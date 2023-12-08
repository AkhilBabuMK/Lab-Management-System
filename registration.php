<?php
include('header.php');

// Initialize variables to store user input
$username = $password = $email = $fullname = $contactnumber = $role = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $contactnumber = $_POST['contactnumber'];
    $role = $_POST['role'];

    // Perform basic validation (you can add more validation as needed)
    if (empty($username) || empty($password) || empty($email) || empty($fullname) || empty($contactnumber) || empty($role)) {
        echo '<div class="container mt-5 alert alert-danger">All fields are required.</div>';
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query to insert data into the Users table
        $sql = "INSERT INTO Users (Role, Username, Password, Email, FullName, ContactNumber, RegistrationDate, Status)
                VALUES ('$role', '$username', '$hashed_password', '$email', '$fullname', '$contactnumber', NOW(), 'enabled')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.html");
            exit();
        } else {
            echo '<div class="container mt-5 alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
}
?>

<?php include('footer.php'); ?>
