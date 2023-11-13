<?php
// Include the database connection and other necessary files
include('header.php');

// Check if the user is logged in
// if (!isset($_SESSION['userid'])) {
//     // Redirect to a login page or display an error message
//     header("Location: login.php");
//     exit();
// }

// Check if the questionID is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questionID'])) {
    $questionID = $_POST['questionID'];

    // Perform the question deletion in the database
    $sql = "DELETE FROM Question WHERE QuestionID = $questionID";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to selectlab.php after successful deletion
        header("Location: selectlab.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Handle the case where questionID is not provided
    echo "Invalid request.";
}
?>
