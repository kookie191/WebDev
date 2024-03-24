<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentID = $_POST['student_id'];
    $courseID = $_POST['course_id'];
    $assignmentGrade = $_POST['assignment_grade'];
    $quizGrade = $_POST['quiz_grade'];
    $finalExamGrade = $_POST['final_exam_grade'];

    // Update grade in the database
    $sql = "UPDATE student_marks SET AssignmentGrade = '$assignmentGrade', QuizGrade = '$quizGrade', FinalExamGrade = '$finalExamGrade' WHERE StudentID = '$studentID' AND CourseID = '$courseID'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin panel with success message
        header("Location: admin.php?edit_success=true");
        exit();
    } else {
        // Redirect back to admin panel with error message
        header("Location: admin.php?edit_error=true");
        exit();
    }
}
?>
