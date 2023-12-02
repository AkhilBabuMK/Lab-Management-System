<?php
session_start();
include('header.php');

// Check if the user is logged in as a teacher
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

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
</head>
<body>

<div class="container mt-5">
    <h2>Students and Their Answers</h2>

    <?php
    // Display the list of students
    if ($resultStudents === false) {
        echo "Error fetching students: " . $conn->error;
    } else {
        while ($rowStudent = $resultStudents->fetch_assoc()) {
            $studentID = $rowStudent['UserID'];
            $studentFullName = $rowStudent['FullName'];

            echo "<div class='card mt-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Student ID: $studentID</h5>";
            echo "<p class='card-text'>Student Name: $studentFullName</p>";

            // Fetch and display answers for this student
            $sqlAnswers = "SELECT * FROM Answer WHERE UserID = $studentID";
            $resultAnswers = $conn->query($sqlAnswers);

            if ($resultAnswers === false) {
                echo "Error fetching answers: " . $conn->error;
            } else {
                if ($resultAnswers->num_rows > 0) {
                    while ($rowAnswer = $resultAnswers->fetch_assoc()) {
                        $answerID = $rowAnswer['AnswerID'];
                        $labID = $rowAnswer['LabID'];
                        $questionID = $rowAnswer['QuestionID'];
                        $status = $rowAnswer['Status1'];
                        $feedback = $rowAnswer['Feedback'];

                        // Progress bar indicating submission status
                        $statusIcon = '❗'; // Default icon and color for unknown status
                        $statusColor = 'bg-danger';

                        if ($status === 'Reviewed') {
                            $statusIcon = '✔️';
                            $statusColor = 'bg-success';
                        } elseif ($status === 'Pending') {
                            $statusIcon = '⌛';
                            $statusColor = 'bg-warning';
                        } elseif ($status === 'Rejected') {
                            $statusIcon = '❌';
                            $statusColor = 'bg-danger';
                        }

                        echo "<div class='progress'>";
                        echo "<div class='progress-bar $statusColor' role='progressbar' style='width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>$statusIcon $status</div>";
                        echo "</div>";

                        // View Answer button triggering a modal
                        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#viewAnswerModal$answerID'>View Answer</button>";

                        // Review and Reject buttons
                        echo "<form action='processAnswer.php' method='post' class='mt-2'>";
                        echo "<input type='hidden' name='answerID' value='$answerID'>";
                        echo "<button type='submit' name='reviewButton' class='btn btn-success'>Accept</button>";
                        echo "<button type='submit' name='rejectButton' class='btn btn-danger ml-2'>Reject</button>";
                        echo "</form>";

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
                    echo "<p>No answers available for this student.</p>";
                }
            }

            echo "</div>";
            echo "</div>";
        }
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
