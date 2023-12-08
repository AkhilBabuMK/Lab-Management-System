<?php
session_start();
include('header.php');

// Check if the user is logged in as a teacher
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Check if the form was submitted with the reviewButton or rejectButton
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the answerID from the form
    $answerID = $_POST['answerID'];

    // Check which button was pressed
    if (isset($_POST['reviewButton'])) {
        // Update the status to 'Reviewed'
        $sql = "UPDATE Answer SET Status1 = 'Reviewed' WHERE AnswerID = ?";
        $message = "Answer reviewed successfully.";
    } elseif (isset($_POST['rejectButton'])) {
        // Update the status to 'Rejected'
        $sql = "UPDATE Answer SET Status1 = 'Rejected' WHERE AnswerID = ?";
        $message = "Answer rejected successfully.";
    } else {
        // Invalid request, handle accordingly
        echo "Invalid request.";
        exit();
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $answerID);

        if ($stmt->execute()) {
            echo $message;
        } else {
            echo "Error processing answer: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

include('footer.php');
?>
