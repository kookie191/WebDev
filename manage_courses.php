<?php
// Include the database connection file
require_once 'dbconn.php';

if (isset($_GET['delete_course'])) {
    $courseID = $_GET['delete_course'];
    
    // SQL query to delete the course
    $sql = "DELETE FROM courses WHERE CourseID='$courseID'";
    
    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin.php after successful deletion
        header("Location: admin.php");
        exit(); // Stop executing further code
    } else {
        echo "Error deleting course: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
