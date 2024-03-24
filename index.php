<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="images/icons/css/font-awesome.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <style>
         /* Add the sidebar CSS styles here */
         .sidebar {
            background-color: #333; /* Sidebar background color */
            color: #fff; /* Sidebar text color */
            width: 250px; /* Sidebar width */
            height: 100%; /* Set sidebar height to fill parent container */
            position: fixed; /* Fix sidebar position */
            top: 0; /* Position sidebar at the top */
            left: 0; /* Position sidebar at the left */
            overflow-y: auto; /* Add scrollbar if content overflows vertically */
        }

.logo {
    text-align: center; /* Center align logo */
    padding: 20px 0; /* Add padding to logo */
}

.logo img {
    width: 120px; /* Adjust logo width */
    height: auto; /* Maintain aspect ratio */
}



        .navbar {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
        }

        .navbar li {
            padding: 15px 20px; /* Add padding to navbar items */
        }

        .navbar li:hover {
            background-color: #555; /* Hover background color */
        }

        .navbar a {
            color: #fff; /* Navbar link color */
            text-decoration: none; /* Remove underline */
            font-size: 18px; /* Font size */
            display: block; /* Display links as block elements */
        }

        .navbar a:hover {
            color: #fff; /* Hover link color */
            text-decoration: none; /* Remove underline on hover */
        }

        /* Styling for active link */
        .navbar .active {
            background-color: #555;
        }

        .course-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            width: 60%; /* Adjust width of the box */
            margin: auto; /* Center align the box */
        }
        .grade-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        .course-box h2 {
            margin-top: 0;
        }

        .header {
    background-color: #444;
    color: #fff;
    padding-left: 95px;
    text-align: center;
    width: 100%; /* Occupy full width */
    top: 0; /* Stick to the top */
    font-size: 15px; /* Reduce font size */
    position: absolute;
    height: 8%;
}

.sidebar {
    z-index: 1100; /* Make sure sidebar is above header */
}

.wrapper {
    margin-top: 60px; /* Adjust this value based on your navbar height */
}

    </style>
</head>
<body>
<div class="header">
    <h1>Dashboard</h1>
    <!-- Additional header content can be added here -->
</div>
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

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span9">
                <?php
                require('dbconn.php'); // Include the database connection file

                // Check if the session is started and if the UserID session variable is set
                if (isset($_SESSION['UserID'])) {
                    $userID = $_SESSION['UserID'];

                    // Retrieve user's enrolled courses from the database
                    $sql_courses = "SELECT DISTINCT CourseID FROM student_marks WHERE StudentID = '$userID'";
                    $result_courses = $conn->query($sql_courses);

                    if ($result_courses) {
                        if ($result_courses->num_rows > 0) {
                            // Fetch grades for each course
                            while ($row_course = $result_courses->fetch_assoc()) {
                                $courseID = $row_course['CourseID'];

                                // Fetch course name from the course table
                                $sql_course_name = "SELECT CourseName FROM courses WHERE CourseID = '$courseID'";
                                $result_course_name = $conn->query($sql_course_name);

                                if ($result_course_name) {
                                    $row_course_name = $result_course_name->fetch_assoc();
                                    $courseName = $row_course_name['CourseName'];

                                    // Display course name
                                    echo "<div class='course-box'>";
                                    echo "<h2>$courseName</h2>";

                                    // Fetch all grades for the course including assignment descriptions from the assignments table
                                    $sql_grades = "SELECT sm.*, a.AssignmentName, a.Description 
                                            FROM student_marks sm 
                                            LEFT JOIN assignments a ON sm.AssignmentID = a.AssignmentID
                                            WHERE sm.StudentID = '$userID' AND sm.CourseID = '$courseID'";

                                    $result_grades = $conn->query($sql_grades);

                                    if ($result_grades) {
                                        // Display grades and details
                                        echo "<div class='grades'>";
                                        while ($row_grade = $result_grades->fetch_assoc()) {
                                            echo "<div class='grade-box'>";
                                            echo "<h3>{$row_grade['AssignmentName']}</h3>";
                                            echo "<p>Assignment Grade: {$row_grade['AssignmentGrade']}</p>";
                                            echo "<p>Quiz Grade: {$row_grade['QuizGrade']}</p>";
                                            echo "<p>Final Exam Grade: {$row_grade['FinalExamGrade']}</p>";
                                            // Add more fields as needed
                                            echo "</div>"; // Close grade-box div
                                        }
                                        echo "</div>"; // Close grades div
                                    } else {
                                        echo "Error fetching grades: " . $conn->error;
                                    }

                                    echo "</div>"; // Close course-box div
                                } else {
                                    echo "Error fetching course name: " . $conn->error;
                                }
                            }
                        } else {
                            // If no courses found for the user
                            echo "<p>No courses enrolled.</p>";
                        }
                    } else {
                        // If there is an error with the query execution
                        echo "Error executing query: " . $conn->error;
                    }
                } else {
                    // If UserID session variable is not set, display an error message
                    echo "<p>Error: Session UserID not set.</p>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer code remains unchanged -->

    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
