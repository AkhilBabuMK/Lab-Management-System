<?php
session_start();
include('header.php');

// Check if the user is logged in as a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Display student details
$studentID = $_SESSION['userid'];
$sqlStudentDetails = "SELECT * FROM Users WHERE UserID = $studentID AND Role = 'Student'";
$resultStudentDetails = $conn->query($sqlStudentDetails);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Student Profile Management</title>
</head>
<body>

<div class="container mt-5">
    <?php
    if ($resultStudentDetails->num_rows > 0) {
        $studentDetails = $resultStudentDetails->fetch_assoc();
        ?>
        <h2>Welcome, <?= $studentDetails['FullName'] ?>!</h2>
        <h3>Your Details:</h3>
        <p>Student ID: <?= $studentDetails['UserID'] ?></p>
        <!-- Add other student details as needed -->
    <?php } else { ?>
        <div class="alert alert-danger">Error fetching student details.</div>
    <?php } ?>

    <!-- Display enrolled labs -->
    <div class="mt-4">
        <h3>Enrolled Labs:</h3>
        <?php
        $resultEnrolledLabs = $conn->query("SELECT Lab.LabID, Lab.LabName FROM Lab
                                           INNER JOIN StudentLab ON Lab.LabID = StudentLab.LabID
                                           WHERE StudentLab.StudentID = $studentID");
        if ($resultEnrolledLabs->num_rows > 0) { ?>
            <ul class="list-group">
                <?php while ($enrolledLab = $resultEnrolledLabs->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        Lab ID: <?= $enrolledLab['LabID'] ?>,
                        Lab Name: <?= $enrolledLab['LabName'] ?>
                        <a href="studentQuestionView.php?labID=<?= $enrolledLab['LabID'] ?>" class="btn btn-primary float-right">View Questions</a>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No labs enrolled.</p>
        <?php } ?>
    </div>

    <!-- Display available labs -->
    <div class="mt-4">
        <h3>Available Labs:</h3>
        <?php
        $resultAvailableLabs = $conn->query("SELECT * FROM Lab");
        if ($resultAvailableLabs->num_rows > 0) { ?>
            <ul class="list-group">
                <?php while ($availableLab = $resultAvailableLabs->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        Lab ID: <?= $availableLab['LabID'] ?>,
                        Lab Name: <?= $availableLab['LabName'] ?>
                        <button class="btn btn-success float-right enroll-btn" data-lab-id="<?= $availableLab['LabID'] ?>">Enroll Lab</button>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No labs available.</p>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // JavaScript to handle the enrollment button click
    document.addEventListener('DOMContentLoaded', function () {
        const enrollButtons = document.querySelectorAll('.enroll-btn');
        
        enrollButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const labID = button.getAttribute('data-lab-id');
                window.location.href = 'student_profile.php?enrollLab=' + labID;
            });
        });
    });
</script>

</body>
</html>

<?php
include('footer.php');
?>
