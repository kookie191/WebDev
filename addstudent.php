<?php
// Include the database connection file
require_once 'dbconn.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentID = $_POST['student_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobile_number'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // SQL query to insert student data into the database
    $sql = "INSERT INTO user (UserID, FirstName, LastName, Type, EmailId, MobNo, Password, gender)
            VALUES ('$studentID', '$firstName', '$lastName', 'student', '$email', '$mobileNumber', '$password', '$gender')";

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
