<?php
include('header.php');

// Initialize variables to store user input
$username = $password = $email = $fullname = $contactnumber = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $contactnumber = $_POST['contactnumber'];
    echo "inside form tag";

    // Perform basic validation (you can add more validation as needed)
    if (empty($username) || empty($password) || empty($email) || empty($fullname) || empty($contactnumber)) {
        echo '<div class="container mt-5 alert alert-danger">All fields are required.</div>';
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "inserting data";
        // Prepare and execute the SQL query to insert data into the Users table
        $sql = "INSERT INTO Users (Role, Username, Password, Email, FullName, ContactNumber, RegistrationDate, Status)
                VALUES ('Student', '$username', '$hashed_password', '$email', '$fullname', '$contactnumber', NOW(), 'enabled')";
echo $sql;
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

