<?php
session_start();
include('header.php');

// Check if the user is logged in as a teacher
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Get the teacher's ID
$teacherID = $_SESSION['userid'];

// Fetch the list of students
$sqlStudents = "SELECT * FROM Users WHERE Role = 'Student'";
$resultStudents = $conn->query($sqlStudents);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Teacher View</title>
    <style>
        .answer-container {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .answer-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Students and Their Answers</h2>

    <?php
    // Display the list of students
    if ($resultStudents === false) {
        echo "<div class='alert alert-danger'>Error fetching students: " . $conn->error . "</div>";
    } else {
        while ($rowStudent = $resultStudents->fetch_assoc()) {
            $studentID = $rowStudent['UserID'];
            $studentFullName = $rowStudent['FullName'];

            echo "<div class='answer-container'>";
            echo "<h4>Student: $studentFullName (ID: $studentID)</h4>";

            // Fetch and display answers for this student and assigned labs
            $sqlAnswers = "SELECT a.*, q.QuestionNumber
                           FROM Answer a
                           JOIN Question q ON a.QuestionID = q.QuestionID
                           WHERE a.UserID = $studentID 
                           AND a.TeacherID = $teacherID";
            $resultAnswers = $conn->query($sqlAnswers);

            if ($resultAnswers === false) {
                echo "<div class='alert alert-danger'>Error fetching answers: " . $conn->error . "</div>";
            } else {
                if ($resultAnswers->num_rows > 0) {
                    while ($rowAnswer = $resultAnswers->fetch_assoc()) {
                        $answerID = $rowAnswer['AnswerID'];
                        $status = $rowAnswer['Status1'];
                        $feedback = $rowAnswer['Feedback'];
                        $questionNumber = $rowAnswer['QuestionNumber'];

                        echo "<div class='answer-actions'>";
                        echo "<span class='badge badge-info'>Question Number: $questionNumber</span>";
                        echo "<span class='badge badge-secondary'>Status: $status</span>";

                        // View Answer button triggering a modal
                        echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#viewAnswerModal$answerID'>View Answer</button>";

                        // Accept and Reject buttons
                        echo "<form action='processAnswer.php' method='post'>";
                        echo "<input type='hidden' name='answerID' value='$answerID'>";
                        echo "<button type='submit' name='reviewButton' class='btn btn-success btn-sm'><i class='fas fa-check'></i> Accept</button>";
                        echo "<button type='submit' name='rejectButton' class='btn btn-danger btn-sm ml-2'><i class='fas fa-times'></i> Reject</button>";
                        echo "</form>";
                        echo "</div>";

                        // Modal for displaying the answer text
                        echo "<div class='modal fade' id='viewAnswerModal$answerID' tabindex='-1' role='dialog' aria-labelledby='viewAnswerModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog' role='document'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='viewAnswerModalLabel'>Answer Text</h5>";
                        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                        echo "</button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";

                        // Fetch the complete answer text
                        $completeAnswerText = "Error fetching complete answer text.";
                        $answerText = $rowAnswer['AnswerText'];
                        if ($answerText !== false) {
                            $completeAnswerText = htmlspecialchars($answerText);
                        }

                        echo "<pre>$completeAnswerText</pre>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>No answers available for this student.</div>";
                }
            }

            echo "</div>";
        }
    }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script> <!-- Replace with your Font Awesome Kit URL -->

</body>
</html>

<?php
include('footer.php');
?>
