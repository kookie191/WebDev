<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="student.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Gradebook</title>
    <style>
        /* Sidebar Styles */
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

    /* Table Styles */
    .container {
        display: flex;
        justify-content: flex-end; /* Align items to the right */
    }

    table {
        width: 70%; /* Adjust width as needed */
        border-collapse: collapse;
        margin-left: 300px; /* Add margin between the sidebar and the table */
        height: 500px; /* Set a fixed height for the table */
        overflow-y: auto; /* Add vertical scrollbar if content overflows */
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 12px; /* Increase padding for better spacing */
    }

    th {
        background-color: #f2f2f2;
    }

    .chart-container {
            width: 60%; /* Adjust chart width */
            margin: 20px auto;
        }

        canvas {
            max-width: 100%; /* Ensure chart is responsive */
            height: auto;
        }
    </style>
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
    <?php
// Include the database connection file
require_once 'dbconn.php';

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect the user to the login page or display an error message
    header("Location: login.php");
    exit(); // Stop executing further code
}

// Retrieve the logged-in user's ID from the session
$userID = $_SESSION['UserID'];

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve grades for the specified user
$sql = "SELECT courses.CourseID, courses.CourseName, 
               student_marks.AssignmentGrade, student_marks.QuizGrade, student_marks.FinalExamGrade
        FROM student_courses
        INNER JOIN courses ON student_courses.CourseID = courses.CourseID
        LEFT JOIN student_marks ON student_courses.StudentID = student_marks.StudentID AND student_courses.CourseID = student_marks.CourseID
        WHERE student_courses.StudentID = '$userID'";

// Execute the SQL query
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

// Check if there are any rows returned
if ($result->num_rows > 0) {
    echo "<h2>Gradebook</h2>";
    echo "<table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Assignment Grade</th>
                <th>Quiz Grade</th>
                <th>Final Exam Grade</th>
                <th>Final Grade</th>
                <th>GPA</th> <!-- New column for GPA -->
            </tr>";

    $totalGradePoints = 0;
    $totalCredits = 0;
    $totalGPA = 0; // New variable to store cumulative GPA

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Calculate the final grade using the given formula (e.g., average of assignment, quiz, and final exam grades)
        $finalGrade = ($row["AssignmentGrade"] + $row["QuizGrade"] + $row["FinalExamGrade"]) / 3;

        // Calculate GPA for the module
        $moduleGPA = calculateModuleGPA($finalGrade);

        echo "<tr>
                <td>".$row["CourseID"]."</td>
                <td>".$row["CourseName"]."</td>
                <td>".$row["AssignmentGrade"]."</td>
                <td>".$row["QuizGrade"]."</td>
                <td>".$row["FinalExamGrade"]."</td>
                <td>".$finalGrade."</td>
                <td>".$moduleGPA."</td> <!-- Display module GPA -->
            </tr>";

        // Calculate grade points and credits for GPA calculation (assuming all courses have equal credits)
        $gradePoints = calculateGradePoints($finalGrade); // Implement this function based on your grading scale
        $totalGradePoints += $gradePoints;
        $totalCredits++; // Assuming all courses have equal credits
        
        // Sum up GPA for cumulative calculation
        $totalGPA += $moduleGPA;
    }
    // Calculate cumulative GPA
    $cumulativeGPA = $totalGPA / $totalCredits;
    echo "<tr><td colspan='6'>Cumulative GPA</td><td>".number_format($cumulativeGPA, 2)."</td></tr>";
    echo "</table>";
} else {
    echo "No grades found for the specified user.";
}

// Close the database connection
$conn->close();

// Function to calculate grade points based on final grade (customize based on your grading scale)
function calculateGradePoints($finalGrade) {
    if ($finalGrade >= 90) {
        return 4.0;
    } elseif ($finalGrade >= 80) {
        return 3.0;
    } elseif ($finalGrade >= 70) {
        return 2.0;
    } elseif ($finalGrade >= 60) {
        return 1.0;
    } else {
        return 0.0;
    }
}

// Function to calculate module GPA based on final grade
function calculateModuleGPA($finalGrade) {
    // Convert final grade to GPA on a 4.0 scale
    if ($finalGrade >= 90) {
        return 4.0;
    } elseif ($finalGrade >= 80) {
        return 3.0;
    } elseif ($finalGrade >= 70) {
        return 2.0;
    } elseif ($finalGrade >= 60) {
        return 1.0;
    } else {
        return 0.0;
    }
}
?>


<div class="chart-container">
        <canvas id="gradeDistributionChart"></canvas>
    </div>

    <script>
        // Sample data for grade distribution
var gradeDistributionData = {
    labels: ['A', 'B', 'C', 'D', 'F'],
    datasets: [{
        label: 'Grade Distribution',
        data: [20, 30, 25, 15, 10], // Sample data percentages
        backgroundColor: [
            'rgba(75, 192, 192, 0.2)', // A
            'rgba(255, 206, 86, 0.2)', // B
            'rgba(54, 162, 235, 0.2)', // C
            'rgba(255, 159, 64, 0.2)', // D
            'rgba(255, 99, 132, 0.2)'  // F
        ],
        borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
    }]
};

// Chart.js configuration options
var chartOptions = {
    tooltips: {
        callbacks: {
            label: function(tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];
                var currentValue = dataset.data[tooltipItem.index];
                return currentValue + '%';
            }
        }
    }
};

// Generate grade distribution chart
var gradeDistributionChart = new Chart(document.getElementById('gradeDistributionChart'), {
    type: 'bar',
    data: gradeDistributionData,
    options: chartOptions
});

    </script>
</body>
</html>