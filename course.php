<?php
require('dbconn.php');

if ($_SESSION['UserID']) {
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackboard</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="courses.css">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
   
</head>

<body>
<div class="sidebar">
    <div class="logo">
        <img src="logo.jpg" alt="Logo">
    </div>
    <ul class="navbar">
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>><a href="profile.php">Profile</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>><a href="index.php">Dashboard</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'gradebook.php') echo 'class="active"'; ?>><a href="gradebook.php">Gradebook</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'course.php') echo 'class="active"'; ?>><a href="course.php">Courses</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="calender.php">Calender</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="login.php">Logout</a></li>
</ul>

</div>


    <div class="container">
    <div class="row">
        <div class="col-md-9"> <!-- Adjust the column width based on your layout -->
        <div class="course-container">
    <?php
    $studentID = $_SESSION['UserID'];
    $sql = "SELECT courses.CourseID, courses.CourseName, courses.CourseCode
            FROM student_courses
            INNER JOIN courses ON student_courses.CourseID = courses.CourseID
            WHERE student_courses.StudentID = '$studentID'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
         <div class="course-card" onclick="showCourseDetails(<?php echo $row['CourseID']; ?>); handleCourseCardClick(<?php echo $row['CourseID']; ?>);">
    <!-- Removed redundant div with class "card" -->
    <div class="card-body">
        <h5 class="card-title"><?php echo $row['CourseName']; ?></h5>
        <p class="card-text"><?php echo $row['CourseCode']; ?></p>
    </div>
</div>

        <?php
        }
    } else {
        echo "<p>No courses enrolled</p>";
    }
    ?>
</div>

        </div>
    </div>
</div>

<div class="generate-button-container">
    <button class="generate-button" onclick="generateQuote()">Generate Inspirational Quote</button>
</div>
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <b class="copyright">&copy; 2024 Blackboard System</b> All rights reserved.
        </div>
    </div>
 
    <!--/.wrapper-->
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Add any additional scripts here -->

    <script>
        // Function to show course details when a card is clicked
        function showCourseDetails(courseID) {
            // Redirect to a page showing detailed course information
            window.location.href = "course_details.php?courseID=" + courseID;
        }

        function showCourseDetails(courseID) {
        // Redirect to a page showing detailed course information
        window.location.href = "course_details.php?courseID=" + courseID;
    }
    
    // Example function to handle additional actions after clicking a course card
    function handleCourseCardClick(courseID) {
        // Add your custom functionality here
        console.log("Course card clicked with ID: " + courseID);
    }
    var quotes = [
        "The only way to do great work is to love what you do. – Steve Jobs",
        "Your limitation—it's only your imagination.",
        "Push yourself, because no one else is going to do it for you.",
        "Great things never come from comfort zones.",
        "Dream it. Wish it. Do it.",
        "Success doesn’t just find you. You have to go out and get it."
    ];

    // Function to generate a random quote
    function generateQuote() {
        // Get a random index within the range of the quotes array
        var index = Math.floor(Math.random() * quotes.length);
        // Display the random quote
        alert(quotes[index]);
    }
    </script>

</body>

</html>

<?php
} else {
    echo "<script type='text/javascript'>alert('Access Denied!!!')</script>";
}
?>
