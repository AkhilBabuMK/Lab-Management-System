<?php
session_start();
include('header.php');

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    //if the student is not loged in move to unauthorized page
    header("Location: unauthorized.php"); 
    exit();
}

// Check if LabID is provided in the URL ie(collected when button pressed or similar action)
if (!isset($_GET['labID'])) {
    // Redirect or display an error message if LabID is not provided
    header("Location: unauthorized.php");
    exit();
}

$labID = $_GET['labID'];

// Fetch questions associated with the selected lab
$sqlQuestions = "SELECT * FROM Question WHERE LabID = $labID ORDER BY QuestionNumber ASC";
$resultQuestions = $conn->query($sqlQuestions);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>View Questions</title>
</head>
<body>

<div class="container mt-5">

    <?php
    // Display the LabID and a heading
    echo "<h2>Questions for Lab ID: $labID</h2>";

    // Display questions
    if ($resultQuestions->num_rows > 0) {
        while ($rowQuestion = $resultQuestions->fetch_assoc()) {
            echo "<div class=\"card mt-3\">";
            echo "<div class=\"card-body\">";
            echo "<h5 class=\"card-title\">Question ID: " . $rowQuestion['QuestionNumber'] . "</h5>";
            echo "<p class=\"card-text\">Question Text: " . $rowQuestion['QuestionText'] . "</p>";
            echo "<p class=\"card-text\">Difficulty Level: " . $rowQuestion['DifficultyLevel'] . "</p>";

            // Add the form for uploading answers
            echo "<form action='uploadAnswer.php' method='post' enctype='multipart/form-data'>";
            echo "<div class='form-group'>";
            echo "<label for='answerUpload'>Upload Answer:</label>";
            echo "<input type='file' class='form-control' name='answerUpload' id='answerUpload' required>";
            echo "<input type='hidden' name='questionID' value='" . $rowQuestion['QuestionID'] . "'>";
            echo "<input type='hidden' name='labID' value='$labID'>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Submit Answer</button>";
            echo "</form>";

            // End of the form

            // Add more details or formatting as needed
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No questions available for this lab.</p>";
    }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
include('footer.php');
?>
