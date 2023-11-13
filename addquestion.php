<?php
// Start or resume the session
session_start();

// Include the database connection and other necessary files
include('header.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

// Check if labID is set in the session
if (!isset($_SESSION['labid'])) {
    // Redirect or display an error, as labID is required for adding questions
    header("Location: selectlab.php"); // Redirect to lab selection page
    exit();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve question information from the form
    $questionText = $_POST['questionText'];
    $difficultyLevel = $_POST['difficultyLevel'];
    $questionNumber = $_POST['questionNumber']; // Assuming the input field in the form is named 'questionNumber'

    // Validate and sanitize input as needed

    // Perform the question insertion in the database
    $labID = $_SESSION['labid'];
    $userID = $_SESSION['userid'];

    // Add the necessary SQL query for inserting the question into the database
    $sql = "INSERT INTO Question (LabID, QuestionNumber, QuestionText, DifficultyLevel, QuestionUploadDate, submissiondate)
            VALUES ('$labID', '$questionNumber', '$questionText', '$difficultyLevel', NOW(), NOW())";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo '<div class="container mt-5 alert alert-success">Question added successfully!</div>';

        // Redirect to selectlab.php after successful submission
        header("Location: selectlab.php");
        exit();
    } else {
        echo '<div class="container mt-5 alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <!-- Include any necessary CSS styles or Bootstrap CDN links here -->
</head>
<body>

<div class="container mt-5">
    <h2>Add Question</h2>

    <!-- Question submission form -->
    <form method="post" action="addquestion.php">
        <div class="form-group">
            <label for="questionText">Question Text:</label>
            <textarea class="form-control" name="questionText" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="difficultyLevel">Difficulty Level:</label>
            <input type="text" class="form-control" name="difficultyLevel" required>
        </div>

        <div class="form-group">
            <label for="questionNumber">Question Number:</label>
            <input type="text" class="form-control" name="questionNumber" required>
        </div>

        <!-- Add other form fields as needed -->

        <button type="submit" class="btn btn-primary">Submit Question</button>
    </form>
</div>

<!-- Include any necessary JavaScript scripts or Bootstrap JS CDN links here -->

<?php include('footer.php'); ?>
</body>
</html>
