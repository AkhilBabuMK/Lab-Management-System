<?php
include('header.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform SQL query to check login credentials
    $sql = "SELECT * FROM Users WHERE Username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

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

            // Insert session record
            $insertSession = "INSERT INTO Session (UserID, LoginTime) VALUES (?, NOW())";
            $stmtInsertSession = $conn->prepare($insertSession);
            $stmtInsertSession->bind_param('i', $_SESSION['userid']);
            $stmtInsertSession->execute();
            $stmtInsertSession->close();

            // Redirect based on user role
            switch ($_SESSION['role']) {
                case 'Teacher':
                    // Redirect teacher to selectlab.php
                    header("Location: selectlab.php");
                    exit();
                    break;
                case 'Student':
                    // Redirect student to studentprofile.php
                    header("Location: studentprofilemanagement.php");
                    exit();
                    break;
                case 'Admin':
                    // Redirect admin to registerlab.php
                    header("Location: registrationlab.php");
                    exit();
                    break;
                default:
                    // Handle other roles or unexpected cases
                    echo '<div class="container mt-5 alert alert-danger">Unknown user role.</div>';
                    break;
            }
        } else {
            echo '<div class="container mt-5 alert alert-danger">Invalid password.</div>';
        }
    } else {
        echo '<div class="container mt-5 alert alert-danger">User not found.</div>';
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

// Include footer.php
include('footer.php');
?>
