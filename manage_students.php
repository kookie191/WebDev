<?php
// Include the database connection file
require_once 'dbconn.php';

if (isset($_GET['delete_student'])) {
    $studentID = $_GET['delete_student'];
    
    // SQL query to delete the student from student_courses table
    $sql_delete_student_courses = "DELETE FROM student_courses WHERE StudentID='$studentID'";
    
    // Execute the SQL query
    if ($conn->query($sql_delete_student_courses) === TRUE) {
        // Now, delete the student from the user table
        $sql_delete_user = "DELETE FROM user WHERE UserID='$studentID'";
        
        // Execute the SQL query
        if ($conn->query($sql_delete_user) === TRUE) {
            // Redirect back to admin.php after successful deletion
            header("Location: admin.php");
            exit(); // Stop executing further code
        } else {
            echo "Error deleting student: " . $conn->error;
        }
    } else {
        echo "Error deleting student: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
