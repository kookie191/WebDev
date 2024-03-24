<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if form is submitted for adding assignments
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_assignment'])) {
    // Retrieve form data
$courseID = $_POST['course_id'];
$assignmentName = $_POST['assignment_name'];
$assignmentWeight = $_POST['assignment_weight'];
$assignmentDescription = $_POST['assignment_description']; // New field for assignment description

// Insert assignment into database
$sql = "INSERT INTO assignments (CourseID, AssignmentName, Weight, Description) VALUES ('$courseID', '$assignmentName', '$assignmentWeight', '$assignmentDescription')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit(); // Stop executing further code
    } else {
        echo "Error adding assignment: " . $conn->error;
    }
}

// Check if form is submitted for removing assignments
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_assignment'])) {
    // Retrieve form data
    $assignmentID = $_POST['assignment_id'];

    // Delete assignment from database
    $sql = "DELETE FROM assignments WHERE AssignmentID='$assignmentID'";
    if ($conn->query($sql) === TRUE) {
        echo "Assignment removed successfully";
    } else {
        echo "Error removing assignment: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
