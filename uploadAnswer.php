<?php
session_start();
include('header.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Check if LabID and QuestionID are provided in the POST data
if (!isset($_POST['labID'], $_POST['questionID'])) {
    // Redirect or display an error message if LabID or QuestionID is not provided
    header("Location: unauthorized.php");
    exit();
}

$labID = $_POST['labID'];
$questionID = $_POST['questionID'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded successfully
    if ($_FILES['answerUpload']['error'] === UPLOAD_ERR_OK) {
        // Get the contents of the uploaded file
        $answerText = file_get_contents($_FILES['answerUpload']['tmp_name']);

        // Store the contents in the database
        $sql = "INSERT INTO Answer (QuestionID, UserID, AnswerText, submissionDate, FileUpload, uploadDate, Status1, Feedback)
                VALUES (?, ?, ?, CURRENT_DATE(), NULL, CURRENT_DATE(), 'Pending', NULL)";

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('iis', $questionID, $_SESSION['userid'], $answerText);

            if ($stmt->execute()) {
                echo "File uploaded successfully and content stored in the database.";
            } else {
                echo "Error storing file content in the database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Error uploading file. Please try again. Error code: " . $_FILES['answerUpload']['error'];
    }
}

include('footer.php');
?>
