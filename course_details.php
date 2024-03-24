<?php
require('dbconn.php');

// Check if the course ID is provided in the URL
if(isset($_GET['courseID'])) {
    $courseID = $_GET['courseID'];

    // Fetch course details from the database based on the provided course ID
    $sql_course = "SELECT * FROM courses WHERE CourseID = '$courseID'";
    $result_course = $conn->query($sql_course);

    if($result_course && $result_course->num_rows > 0) {
        $row_course = $result_course->fetch_assoc();
        $courseName = $row_course['CourseName'];
        $courseCode = $row_course['CourseCode'];
        $tutor = $row_course['Tutor']; // Added tutor
        $description = $row_course['Description']; // Added description
        $term = $row_course['Term']; // Added term
        // Add more fields as needed
    } else {
        // Handle if no course is found
        $courseName = "Course Not Found";
        $courseCode = "N/A";
        $tutor = "Tutor not available";
        $description = "Description not available";
        $term = "Term not available"; // Default term value
    }

    // Fetch assignments for the course from the database
    $sql_assignments = "SELECT * FROM assignments WHERE CourseID = '$courseID'";
    $result_assignments = $conn->query($sql_assignments);
} else {
    // Handle if course ID is not provided in the URL
    $courseName = "Course Not Selected";
    $courseCode = "N/A";
    $tutor = "Tutor not available";
    $description = "Description not available";
    $term = "Term not available"; // Default term value
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="courses.css">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <style>
        body {
            background-color: whitesmoke;
        }
        .container {
            margin-left: 20px; /* Adjust the left margin as needed */
        }
        /* Navbar styles remain the same */
        /* ... */

        .card {
            margin-top: 20px; /* Add some margin to the card */
            width: 100%; /* Make the card width full */
        }

        .left-align {
            text-align: left;
        }

        /* Additional style for assignment table */
        .assignment-table {
            width: 100%; /* Adjust width as needed */
            margin: auto; /* Center align the table */
            border-collapse: collapse;
            border: 1px solid #ddd;
            background-color: #333; /* Dark mode background */
            color: #fff; /* Dark mode text color */
            font-size: 14px; /* Smaller font size */
        }
        .assignment-table th, .assignment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .assignment-table th {
            background-color: #444; /* Dark mode table header background */
            color: #fff; /* Dark mode table header text color */
        }
        .assignment-table tbody tr:nth-child(odd) {
            background-color: #444; /* Dark mode table row background color */
        }
        .assignment-table tbody tr:nth-child(even) {
            background-color: #333; /* Dark mode table row background color */
        }

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

    /* Navbar */
    .navbar {
        background-color: #333; /* Dark background color */
        color: #fff; /* Light text color */
        list-style-type: none; /* Remove bullet points */
        padding: 0; /* Remove default padding */
        display: flex; /* Display navbar items in a row */
        justify-content: center; /* Center align navbar items */
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
        .left-align {
            text-align: left;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="container-fluid">
        <ul class="navbar">
        <li <?php if(basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>><a href="profile.php">Profile</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>><a href="index.php">Dashboard</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'gradebook.php') echo 'class="active"'; ?>><a href="gradebook.php">Gradebook</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'course.php') echo 'class="active"'; ?>><a href="course.php">Courses</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="calender.php">Calender</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="login.php">Logout</a></li>
</ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 left-align">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $courseName; ?></h2>
                        <h5 class="card-subtitle mb-3 text-muted">Course Code: <?php echo $courseCode; ?></h5>
                        <p class="card-text"><strong>Tutor:</strong> <?php echo $tutor; ?></p>
                        <p class="card-text"><strong>Description:</strong> <?php echo $description; ?></p>
                        <p class="card-text"><strong>Term:</strong> <?php echo $term; ?></p>
                        <!-- Add more details about the course here -->

                        <!-- Display assignments for the course -->
                        <h3>Assignments</h3>
                        <?php
                        if($result_assignments && $result_assignments->num_rows > 0) {
                            echo "<table class='assignment-table'>";
                            echo "<thead><tr><th>Assignment Name</th><th>Weight</th><th>Description</th></tr></thead>";
                            echo "<tbody>";
                            while ($row_assignment = $result_assignments->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_assignment['AssignmentName'] . "</td>";
                                echo "<td>" . $row_assignment['Weight'] . "</td>";
                                echo "<td>" . $row_assignment['Description'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No assignments found for this course.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer mt-5">
        <div class="container">
            <p>&copy; 2024 Blackboard System. All rights reserved.</p>
        </div>
    </div>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
