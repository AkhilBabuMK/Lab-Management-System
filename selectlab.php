<?php
// Start or resume the session
include('header.php');

session_start();

// Debug statement

// Check if the user is logged in and has the role 'Teacher'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    // Debug statement
    echo "Redirecting to unauthorized.php. Role: " . $_SESSION['role'];

    // Redirect to an unauthorized access page or display an error message
    header("Location: unauthorized.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    // Retrieve username and password from the form
    
    $_SESSION['labid'] = $_POST['selectedLab'];
    $currentLab =  $_SESSION['labid'];
    echo "current lab is " ,$currentLab;

    // Fetch questions associated with the selected lab
    $sqlQuestions = "SELECT * FROM Question WHERE LabID = $currentLab ORDER BY QuestionNumber ASC";
    $resultQuestions = $conn->query($sqlQuestions);

    if (!$resultQuestions) {
        // Handle the case where the query fails
        echo "Error: " . $sqlQuestions . "<br>" . $conn->error;
    }
    
}
   else{
   echo "world";
   }
// Debug statement
echo "After checking role. Role: " . $_SESSION['role'];

// Check if TeacherID is available in the session
if (!isset($_SESSION['username'])) {
    // Debug statement
    echo "Redirecting to login.php because userID is not set.";
    
    // Redirect to a login page or display an error message
    header("Location: login.php");
    exit();
}

// Debug statement
echo "After checking userID. UserID: " . $_SESSION['userid'];

// Include the database connection or any necessary configuration files
// require_once('config.php');

// Fetch LabIDs associated with the logged-in teacher
$teacherID = $_SESSION['userid']; // Assuming TeacherID is stored in the session as userID

// Debug statement
echo "Teacher ID: " . $teacherID;

// Adjust the SQL query based on your actual database schema
$sql = "SELECT LabID FROM Lab WHERE TeacherID = $teacherID";
echo $sql;
// Execute the query (assuming $conn is your database connection)

$result = $conn->query($sql);
 echo "fetching hjhjhjkhkhkjresult";
// Check if the query was successful
if ($result) {
    // Fetch LabIDs and store them in an array
    $labIDs = [];
    echo "fetching result";
    while ($row = $result->fetch_assoc()) {
        $labIDs[] = $row['LabID'];
    }

    // Store the LabIDs in a session variable
    $_SESSION['teacherLabIDs'] = $labIDs;
    echo $labIDs;
} else {
   echo "fetching error";
    // Handle the case where the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Your HTML and PHP code for displaying the available labs go here
// You can use the stored LabIDs to display available labs or options in a form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Lab</title>
    <!-- Include Bootstrap CSS link or CDN here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>


<div class="container">

    <h2 class="mb-4">Select a Lab</h2>

    <!-- Add Question button -->
    

    <form method="POST" action="selectlab.php">
        <div class="form-group">
            <label for="labSelect">Select Lab:</label>
            <select class="form-control" name="selectedLab" id="labSelect" required>
                <?php
                // Use the stored LabIDs to display lab options
                foreach ($labIDs as $labID) {
                    echo "<option value=\"$labID\">Lab $labID</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Select Lab</button>
        <a href="addquestion.php" class="btn btn-primary">Add Question</a>
    </form>

   
<?php
// Display questions only if the lab is selected
if (isset($_SESSION['labid'])) {
    echo "<div class=\"mt-5\">";
    echo "<h2>Questions for the Selected Lab</h2>";

    while ($rowQuestion = $resultQuestions->fetch_assoc()) {
        echo "<div class=\"card mt-3\">";
        echo "<div class=\"card-body\">";
        echo "<h5 class=\"card-title\">Question ID: " . $rowQuestion['QuestionNumber'] . "</h5>";
        echo "<p class=\"card-text\">Question Text: " . $rowQuestion['QuestionText'] . "</p>";
        echo "<p class=\"card-text\">Difficulty Level: " . $rowQuestion['DifficultyLevel'] . "</p>";
    
        // Add delete button
        echo "<form method=\"POST\" action=\"deletequestion.php\">";
        echo "<input type=\"hidden\" name=\"questionID\" value=\"" . $rowQuestion['QuestionID'] . "\">";
        echo "<button type=\"submit\" class=\"btn btn-danger\">Delete Question</button>";
        
        echo "&nbsp&nbsp&nbsp";
        // Add edit button
        echo "<a href=\"addquestion.php?editquestionid=" . $rowQuestion['QuestionID'] . "\" class=\"btn btn-warning\">Edit Question</a>";
        echo "</form>";
        // Add more details or formatting as needed
        echo "</div>";
        echo "</div>";
    }
    

    echo "</div>";
}
?>
</div>

<!-- Include Bootstrap JS and jQuery CDN links here if needed -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
