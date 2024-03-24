<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $studentID = $_POST['student_id'];
    $courseID = $_POST['course_id'];

    // SQL query to delete the student from the student_courses table
    $sql = "DELETE FROM student_courses WHERE StudentID = '$studentID' AND CourseID = '$courseID'";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Student dropped successfully
        echo "Student dropped successfully.";
    } else {
        // Error occurred while dropping student
        echo "Error dropping student: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
