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
                $enrollMessage = "Lab enrolled successfully!";
            } else {
                $enrollMessage = "Error enrolling in the lab: " . $conn->error;
            }
        } else {
            $enrollMessage = "You are already enrolled in this lab.";
        }
    }

    // Unenroll from a lab
    elseif (isset($_POST['unenrollLab']) && isset($_POST['confirmUnenroll'])) {
        $labIDToUnenroll = $_POST['unenrollLab'];
        $studentID = $_SESSION['userid'];

        // Perform unenrollment
        $unenrollSql = "DELETE FROM StudentLab WHERE StudentID = $studentID AND LabID = $labIDToUnenroll";
        if ($conn->query($unenrollSql) === TRUE) {
            $unenrollMessage = "Lab unenrolled successfully!";
        } else {
            $unenrollMessage = "Error unenrolling from the lab: " . $conn->error;
        }
    }
}

// Fetch the available labs for enrollment
$sql = "SELECT * FROM Lab";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .lab-card {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="mt-5 mb-4">Available Labs for Enrollment</h2>

        <?php
        while ($row = $result->fetch_assoc()) {
            $isEnrolled = false;
            $labID = $row['LabID'];

            // Check if the student is already enrolled in the lab
            $checkEnrollmentSql = "SELECT * FROM StudentLab WHERE StudentID = {$_SESSION['userid']} AND LabID = $labID";
            $resultCheckEnrollment = $conn->query($checkEnrollmentSql);

            if ($resultCheckEnrollment->num_rows > 0) {
                $isEnrolled = true;
            }
        ?>

            <div class="card lab-card">
                <div class="card-body">
                    <h5 class="card-title">Lab ID: <?= $row['LabID'] ?></h5>
                    <p class="card-text">Lab Name: <?= $row['LabName'] ?></p>

                    <?php if ($isEnrolled) { ?>
                        <button class="btn btn-danger" disabled>Enrolled</button>
                        <form class="d-inline" method="POST" action="student_profile.php">
                            <input type="hidden" name="unenrollLab" value="<?= $row['LabID'] ?>">
                            <button type="button" class="btn btn-warning" onclick="confirmAction('unenroll')">Unenroll Lab</button>
                            <input type="hidden" name="confirmUnenroll" id="confirmUnenroll" value="">
                        </form>
                    <?php } else { ?>
                        <form class="d-inline" method="POST" action="student_profile.php">
                            <input type="hidden" name="enrollLab" value="<?= $row['LabID'] ?>">
                            <button type="button" class="btn btn-success" onclick="confirmAction('enroll')">Enroll Lab</button>
                            <input type="hidden" name="confirmEnroll" id="confirmEnroll" value="">
                        </form>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>

        <?php
        if (isset($enrollMessage)) {
            echo '<div class="alert alert-success mt-4">' . $enrollMessage . '</div>';
        }

        if (isset($unenrollMessage)) {
            echo '<div class="alert alert-success mt-4">' . $unenrollMessage . '</div>';
        }

        if ($result->num_rows === 0) {
            echo '<div class="alert alert-info mt-4">No labs available for enrollment.</div>';
        }
        ?>
    </div>

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

    <?php include('footer.php'); ?>
</body>

</html>
