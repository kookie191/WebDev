<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $courseID = $_POST['course_id'];
    $courseName = $_POST['course_name'];
    $courseCode = $_POST['course_code'];
    $tutor = $_POST['tutor'];
    $description = $_POST['description'];
    $term = $_POST['term'];

    // SQL query to insert course data into the database
    $sql = "INSERT INTO courses (CourseID, CourseName, CourseCode, Tutor, Description, Term)
            VALUES ('$courseID', '$courseName', '$courseCode', '$tutor', '$description', '$term')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Redirect to the admin panel
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
