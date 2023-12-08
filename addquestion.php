<?php
// Start or resume the session
session_start();

// Include the database connection and other necessary files
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

// Process the form submission for adding/editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve question information from the form
    $questionText = $_POST['questionText'];
    $difficultyLevel = $_POST['difficultyLevel'];
    $questionNumber = $_POST['questionNumber']; // Add this line to get question number from the form

    // Validate and sanitize input as needed

    // Perform the question insertion/update in the database
    $labID = $_SESSION['labid'];

    if (isset($_POST['editquestionid'])) {
        // Editing existing question
        $editQuestionID = $_POST['editquestionid'];
        $updateSql = "UPDATE Question SET 
                      QuestionText = '$questionText', 
                      DifficultyLevel = '$difficultyLevel',
                      QuestionNumber = '$questionNumber' 
                      WHERE QuestionID = $editQuestionID";

        // Execute the update query
        if ($conn->query($updateSql) === TRUE) {
            echo '<div class="container mt-5 alert alert-success">Question updated successfully!</div>';
            header("Location: selectlab.php"); // Redirect after successful update
            exit();
        } else {
            echo '<div class="container mt-5 alert alert-danger">Error updating question: ' . $conn->error . '</div>';
        }
    } else {
        // Adding new question
        $insertSql = "INSERT INTO Question (LabID, QuestionNumber, QuestionText, DifficultyLevel, QuestionUploadDate, submissiondate)
                      VALUES ('$labID', '$questionNumber', '$questionText', '$difficultyLevel', NOW(), NOW())";

        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo '<div class="container mt-5 alert alert-success">Question added successfully!</div>';
            header("Location: selectlab.php"); // Redirect after successful insertion
            exit();
        } else {
            echo '<div class="container mt-5 alert alert-danger">Error adding question: ' . $conn->error . '</div>';
        }
    }
}

// If editing, fetch the existing question details for pre-filling the form
if (isset($_GET['editquestionid'])) {
    $editQuestionID = $_GET['editquestionid'];
    $fetchSql = "SELECT * FROM Question WHERE QuestionID = $editQuestionID";
    $result = $conn->query($fetchSql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $editQuestionText = $row['QuestionText'];
        $editDifficultyLevel = $row['DifficultyLevel'];
        $editQuestionNumber = $row['QuestionNumber']; // Add this line to get question number for editing
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Question</title>
    <!-- Include any necessary CSS styles or Bootstrap CDN links here -->
</head>
<body>

<div class="container mt-5">
    <?php
    if (isset($_GET['editquestionid'])) {
        echo '<h2>Edit Question</h2>';
    } else {
        echo '<h2>Add Question</h2>';
    }
    ?>

    <!-- Question submission/editing form -->
    <form method="post" action="addquestion.php">
        <?php
        if (isset($_GET['editquestionid'])) {
            echo '<input type="hidden" name="editquestionid" value="' . $_GET['editquestionid'] . '">';
        }
        ?>

        <div class="form-group">
            <label for="questionText">Question Text:</label>
            <textarea class="form-control" name="questionText" rows="4" required><?php echo isset($editQuestionText) ? $editQuestionText : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="difficultyLevel">Difficulty Level:</label>
            <input type="text" class="form-control" name="difficultyLevel" value="<?php echo isset($editDifficultyLevel) ? $editDifficultyLevel : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="questionNumber">Question Number:</label>
            <input type="text" class="form-control" name="questionNumber" value="<?php echo isset($editQuestionNumber) ? $editQuestionNumber : ''; ?>" required>
        </div>
        <!-- Add other form fields as needed -->

        <button type="submit" class="btn btn-primary"><?php echo isset($_GET['editquestionid']) ? 'Update' : 'Submit'; ?> Question</button>
    </form>
</div>
<div style="height: 360px;">
    
</div>

<!-- Include any necessary JavaScript scripts or Bootstrap JS CDN links here -->

<?php include('footer.php'); ?>
</body>
</html>
