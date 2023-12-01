<?php
session_start();

include('header.php');

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Check if the form for enrolling or unenrolling in a lab is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Enroll in a lab
    if (isset($_POST['enrollLab']) && isset($_POST['confirmEnroll'])) {
        $labIDToEnroll = $_POST['enrollLab'];
        $studentID = $_SESSION['userid'];

        // Check if the student is already enrolled in the selected lab
        $checkEnrollmentSql = "SELECT * FROM StudentLab WHERE StudentID = $studentID AND LabID = $labIDToEnroll";
        $resultCheckEnrollment = $conn->query($checkEnrollmentSql);

        if ($resultCheckEnrollment->num_rows == 0) {
            // If not already enrolled, perform the enrollment
            $enrollSql = "INSERT INTO StudentLab (StudentID, LabID) VALUES ($studentID, $labIDToEnroll)";
            if ($conn->query($enrollSql) === TRUE) {
                echo '<div class="container mt-5 alert alert-success">Lab enrolled successfully!</div>';
            } else {
                echo '<div class="container mt-5 alert alert-danger">Error enrolling in the lab: ' . $conn->error . '</div>';
            }
        } else {
            echo '<div class="container mt-5 alert alert-warning">You are already enrolled in this lab.</div>';
        }
    }

    // Unenroll from a lab
    elseif (isset($_POST['unenrollLab']) && isset($_POST['confirmUnenroll'])) {
        $labIDToUnenroll = $_POST['unenrollLab'];
        $studentID = $_SESSION['userid'];

        // Perform unenrollment
        $unenrollSql = "DELETE FROM StudentLab WHERE StudentID = $studentID AND LabID = $labIDToUnenroll";
        if ($conn->query($unenrollSql) === TRUE) {
            echo '<div class="container mt-5 alert alert-success">Lab unenrolled successfully!</div>';
        } else {
            echo '<div class="container mt-5 alert alert-danger">Error unenrolling from the lab: ' . $conn->error . '</div>';
        }
    }
}

// Fetch the available labs for enrollment
$sql = "SELECT * FROM Lab";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container mt-5">';
    echo '<h2>Available Labs for Enrollment</h2>';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="card mt-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Lab ID: ' . $row['LabID'] . '</h5>';
        echo '<p class="card-text">Lab Name: ' . $row['LabName'] . '</p>';

        // Add enroll button
        echo '<form method="POST" action="student_profile.php">';
        echo '<input type="hidden" name="enrollLab" value="' . $row['LabID'] . '">';
        echo '<button type="button" class="btn btn-success" onclick="confirmAction(\'enroll\')">Enroll Lab</button>';
        echo '<input type="hidden" name="confirmEnroll" id="confirmEnroll" value="">';
        echo '</form>';

        // Add unenroll button
        echo '<form method="POST" action="student_profile.php">';
        echo '<input type="hidden" name="unenrollLab" value="' . $row['LabID'] . '">';
        echo '<button type="button" class="btn btn-danger" onclick="confirmAction(\'unenroll\')">Unenroll Lab</button>';
        echo '<input type="hidden" name="confirmUnenroll" id="confirmUnenroll" value="">';
        echo '</form>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
} else {
    echo '<div class="container mt-5 alert alert-info">No labs available for enrollment.</div>';
}

include('footer.php');
?>
<script>
    function confirmAction(action) {
        var confirmation = confirm("Are you sure you want to " + action + " in the lab?");
        if (confirmation) {
            if (action === 'enroll') {
                document.getElementById('confirmEnroll').value = '1';
            } else if (action === 'unenroll') {
                document.getElementById('confirmUnenroll').value = '1';
            }
            // Submit the form
            event.target.form.submit();
        }
    }
</script>
