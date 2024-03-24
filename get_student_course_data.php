<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if student_id and course_id are provided via GET request
if (isset($_GET['student_id']) && isset($_GET['course_id'])) {
    // Retrieve student_id and course_id from the GET parameters
    $studentID = $_GET['student_id'];
    $courseID = $_GET['course_id'];

    // Initialize an array to store the data
    $data = array();

    // Fetch assignment grades, quiz grade, and final exam grade from the database
    $sql = "SELECT a.AssignmentName, g.AssignmentGrade
            FROM assignments a
            LEFT JOIN student_marks g ON a.AssignmentID = g.AssignmentID
            WHERE g.StudentID = '$studentID' AND g.CourseID = '$courseID'";
    $result = $conn->query($sql);

    // Check if there are any assignment grades
    if ($result->num_rows > 0) {
        // Loop through each row of the result set
        while ($row = $result->fetch_assoc()) {
            // Store assignment name and grade in an associative array
            $assignmentData = array(
                'assignment_name' => $row['AssignmentName'],
                'grade' => $row['AssignmentGrade']
            );
            // Push the associative array to the data array
            $data['assignmentGrades'][] = $assignmentData;
        }
    }

    // Fetch quiz grade and final exam grade from the database
    $sql = "SELECT QuizGrade, FinalExamGrade
            FROM student_marks
            WHERE StudentID = '$studentID' AND CourseID = '$courseID'";
    $result = $conn->query($sql);

    // Check if there is exactly one row in the result set
    if ($result->num_rows == 1) {
        // Fetch the row
        $row = $result->fetch_assoc();
        // Store quiz grade and final exam grade in the data array
        $data['quizGrade'] = $row['QuizGrade'];
        $data['finalExamGrade'] = $row['FinalExamGrade'];
    }

    // Close the database connection
    $conn->close();

    // Encode the data array as JSON and output it
    echo json_encode($data);
} else {
    // If student_id and course_id are not provided, return an error message
    echo json_encode(array('error' => 'Student ID and Course ID are required.'));
}
?>
