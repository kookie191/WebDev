<?php
// Include the database connection file
require_once 'dbconn.php';

// Function to add a student to a course
if (isset($_POST['add_student_to_course'])) {
    $studentID = $_POST['student_id'];
    $courseID = $_POST['course_id'];
    
    // Check if the student is already enrolled in the course
    $check_enrollment_sql = "SELECT * FROM student_courses WHERE StudentID='$studentID' AND CourseID='$courseID'";
    $check_result = $conn->query($check_enrollment_sql);
    
    if ($check_result->num_rows > 0) {
        echo "The student is already enrolled in the course.";
        header("Location: admin.php");
        exit(); // Stop executing further code
    } else {
        // Add the student to the course
        $add_student_sql = "INSERT INTO student_courses (StudentID, CourseID) VALUES ('$studentID', '$courseID')";
        if ($conn->query($add_student_sql) === TRUE) {
            header("Location: admin.php");
            exit(); // Stop executing further code
        } else {
            echo "Error adding student to the course: " . $conn->error;
        }
    }
}

// Function to drop a student from a course
if (isset($_POST['drop_student_from_course'])) {
    $studentID = $_POST['student_id'];
    $courseID = $_POST['course_id'];
    
    // Remove the student from the course
    $drop_student_sql = "DELETE FROM student_courses WHERE StudentID='$studentID' AND CourseID='$courseID'";
    if ($conn->query($drop_student_sql) === TRUE) {
        header("Location: admin.php");
        exit(); // Stop executing further code
    } else {
        echo "Error dropping student from the course: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
