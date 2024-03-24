<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $studentID = $_POST['student_id'];
    $courseID = $_POST['course_id'];
    $assignmentGrade = $_POST['assignment_grade'];
    $quizGrade = $_POST['quiz_grade'];
    $finalExamGrade = $_POST['final_exam_grade'];

    // Calculate the final grade by considering all exams (assignments, quizzes, and final exam)
    $finalGrade = ($assignmentGrade + $quizGrade + $finalExamGrade) / 3;

    // Check if the final grade is within the valid range (0 to 100)
    if ($finalGrade < 0 || $finalGrade > 100) {
        echo "Error: Invalid final grade. Please ensure all grades are within the range of 0 to 100.";
        exit();
    }

    // Check if a grade already exists for the student and course
    $check_sql = "SELECT * FROM student_marks WHERE StudentID = '$studentID' AND CourseID = '$courseID'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // If a grade already exists, update the existing grade
        $update_sql = "UPDATE student_marks 
                       SET AssignmentGrade = '$assignmentGrade', 
                           QuizGrade = '$quizGrade', 
                           FinalExamGrade = '$finalExamGrade', 
                           Grade = '$finalGrade'
                       WHERE StudentID = '$studentID' AND CourseID = '$courseID'";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: admin.php");
        exit(); // Stop executing further code
        } else {
            // Error occurred while updating grade
            echo "Error updating grade: " . $conn->error;
        }
    } else {
        // If no grade exists, insert the new grade into the database
        $insert_sql = "INSERT INTO student_marks (StudentID, CourseID, AssignmentGrade, QuizGrade, FinalExamGrade, Grade) 
                       VALUES ('$studentID', '$courseID', '$assignmentGrade', '$quizGrade', '$finalExamGrade', '$finalGrade')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: admin.php");
            exit(); // Stop executing further code
        } else {
            // Error occurred while adding grade
            echo "Error adding grade: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>
