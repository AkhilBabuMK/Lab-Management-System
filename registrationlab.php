<?php
include('header.php');

// Check if the user is logged in and has the role 'Admin'
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

// Process the lab registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve lab information from the form
    $labName = $_POST['labName'];
    $labDescription = $_POST['labDescription'];
    $teacherID = $_POST['teacherID'];
    $roomNumber = $_POST['roomNumber'];

    // Validate and sanitize input as needed

    // Perform the lab registration in the database
     $sql = "INSERT INTO Lab (LabName, LabDescription, TeacherID, RoomNumber) VALUES ('$labName', '$labDescription', '$teacherID', '$roomNumber')";
    // Your database connection and insertion code goes here
  if ($conn->query($sql) === TRUE) {
    echo '<div class="container mt-5 alert alert-success">Lab registration successful!</div>';
}
else{
 echo '<div class="container mt-5 alert alert-danger">Lab registration unsuccessful!</div>';
}}
?>

<div class="container mt-5">
    <h2>Lab Registration</h2>

    <!-- Lab registration form -->
    <form method="post" action="registrationlab.php">
        <div class="form-group">
            <label for="labName">Lab Name:</label>
            <input type="text" class="form-control" name="labName" required>
        </div>

        <div class="form-group">
            <label for="labDescription">Lab Description:</label>
            <textarea class="form-control" name="labDescription" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="teacherID">Teacher ID:</label>
            <input type="text" class="form-control" name="teacherID" required>
        </div>

        <div class="form-group">
            <label for="roomNumber">Room Number:</label>
            <input type="text" class="form-control" name="roomNumber" required>
        </div>

        <button type="submit" class="btn btn-primary">Register Lab</button>
    </form>
</div>

<?php include('footer.php'); ?>

