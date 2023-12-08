<?php
session_start();
include('header.php');


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    
    header("Location: unauthorized.php");
    exit();
}

// Check if LabID and QuestionID are provided in the POST data
if (!isset($_POST['labID'], $_POST['questionID'])) {
    
    header("Location: unauthorized.php");
    exit();
}

$labID = $_POST['labID'];
$questionID = $_POST['questionID'];

// Get the current user's ID (student ID)
$userID = $_SESSION['userid'];

// Fetch the TeacherID associated with the provided LabID
$sqlTeacherID = "SELECT TeacherID FROM Lab WHERE LabID = ?";
$stmtTeacherID = $conn->prepare($sqlTeacherID);

if ($stmtTeacherID) {
    $stmtTeacherID->bind_param('i', $labID);
    $stmtTeacherID->execute();
    $stmtTeacherID->bind_result($teacherID);

    // Fetch the result
    if ($stmtTeacherID->fetch()) {
        $stmtTeacherID->close();

        // Check if a file was uploaded successfully
        if ($_FILES['answerUpload']['error'] === UPLOAD_ERR_OK) {
            // Get the contents of the uploaded file
            $answerText = file_get_contents($_FILES['answerUpload']['tmp_name']);

            // Store the contents in the database along with LabID and TeacherID
            $sql = "INSERT INTO Answer (QuestionID, UserID, AnswerText, submissionDate, FileUpload, uploadDate, Status1, Feedback, TeacherID, LabID)
                    VALUES (?, ?, ?, CURRENT_DATE(), NULL, CURRENT_DATE(), 'Pending', NULL, ?, ?)";

            // Use a prepared statement to prevent SQL injection
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('iissi', $questionID, $userID, $answerText, $teacherID, $labID);

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
    } else {
        echo "Error fetching TeacherID: " . $stmtTeacherID->error;
    }
} else {
    echo "Error preparing TeacherID statement: " . $conn->error;
}

include('footer.php');
?>
