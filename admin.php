<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="sidenav">
        <a href="#" onclick="scrollToSection('manageStudents')">Manage Students</a>
        <a href="#" onclick="scrollToSection('manageCourses')">Manage Courses</a>
        <a href="#" onclick="scrollToSection('manageAssignments')">Manage Assignments</a>
        <a href="#" onclick="scrollToSection('manageGrades')">Manage Grades</a>
        <a href="#" onclick="scrollToSection('addDrop')">Add/Drop Student</a>
        <a href="#" onclick="scrollToSection('courseEnrollments')">Course Enrollment</a>
        
        <a href="login.php">Log Out</a>
    </div>
    <div class="container">
        <h1>Welcome to Admin Panel</h1>
        
        <!-- Section to manage students -->
        <div class="section" id="manageStudents">
            <h2>Manage Students</h2>
            <button onclick="openAddStudentModal()">Add Student</button>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php
                // Include the database connection file
                require_once 'dbconn.php';
                
                // Retrieve all students from the database
                $sql = "SELECT * FROM user WHERE Type = 'student'";
                $result = $conn->query($sql);
                
                // Display each student in a table row
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['UserID']."</td>";
                        echo "<td>".$row['FirstName']." ".$row['LastName']."</td>";
                        echo "<td><button onclick=\"deleteStudent('".$row['UserID']."')\">Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No students found.</td></tr>";
                }

                ?>
            </table>
        </div>
        
        <!-- Section to manage courses -->
        <div class="section" id="manageCourses">
            <h2>Manage Courses</h2>
            <button onclick="openAddCourseModal()">Add Course</button>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php
                // Retrieve all courses from the database
                $sql = "SELECT * FROM courses";
                $result = $conn->query($sql);
                
                // Display each course in a table row
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['CourseID']."</td>";
                        echo "<td>".$row['CourseName']."</td>";
                        echo "<td><button onclick=\"deleteCourse('".$row['CourseID']."')\">Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No courses found.</td></tr>";
                }
                ?>
            </table>
        </div>
        
        <!-- Section to manage assignments -->
<div class="section" style="text-align: justify;" id="manageAssignments">
    <h2>Manage Assignments</h2>
    <form action="manage_assignments.php" method="post">
        <!-- First line -->
        <div>
            <div style="display: inline-block; width: 48%;">
                <label for="course_id">Select Course:</label>
                <select name="course_id" id="course_id" required>
                    <?php
                    // Retrieve all courses from the database
                    $sql = "SELECT * FROM courses";
                    $result = $conn->query($sql);

                    // Display each course as an option
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['CourseID']."'>".$row['CourseName']."</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No courses available</option>";
                    }
                    ?>
                </select>
            </div>
            <div style="display: inline-block; width: 48%;">
                <label for="assignment_weight">Assignment Weight:</label>
                <input type="number" name="assignment_weight" min="0" required>
            </div>
        </div>
        <!-- Second line -->
        <div>
            <div style="display: inline-block; width: 48%;">
                <label for="assignment_name">Assignment Name:</label>
                <textarea name="assignment_name" required style="background-color: white; color: black;"></textarea>
            </div>
            <div style="display: inline-block; width: 48%;">
                <label for="assignment_description">Assignment Description:</label>
                <textarea name="assignment_description" required></textarea>
            </div>
        </div>
        <!-- Third line (button) -->
        <div style="text-align: center;">
            <input type="submit" name="add_assignment" value="Add Assignment">
        </div>
    </form>
    <!-- Form for removing assignment -->
    <form action="manage_assignments.php" method="post">
        <!-- Dropdown for selecting assignment -->
        <div>
            <label for="assignment_id">Select Assignment:</label>
            <select name="assignment_id" id="assignment_id" required>
                <?php
                // Retrieve all assignments from the database
                $sql = "SELECT * FROM assignments";
                $result = $conn->query($sql);

                // Display each assignment as an option
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['AssignmentID']."'>".$row['AssignmentName']."</option>";
                    }
                } else {
                    echo "<option value='' disabled>No assignments available</option>";
                }
                ?>
            </select>
        </div>
        <!-- Button for removing assignment -->
        <div style="text-align: center;">
            <input type="submit" name="remove_assignment" value="Remove Assignment">
        </div>
    </form>
</div>

<!-- Section to manage grades -->
<div class="section" id="manageGrades">
    <h2>Manage Grades</h2>
    <!-- Button to open modal for adding/editing grade -->
    <button onclick="openAddGradeModal()">Add/Edit Grade</button>
    <!-- Table to display grades -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Course</th>
            <th>Assignment Grade</th>
            <th>Quiz Grade</th>
            <th>Final Exam Grade</th>
        </tr>
        <?php
        // Include the database connection file
        require_once 'dbconn.php';
        
        // Retrieve all grades with student and course information
        $sql = "SELECT sm.StudentID, CONCAT(u.FirstName, ' ', u.LastName) AS StudentName, c.CourseName, sm.AssignmentGrade, sm.QuizGrade, sm.FinalExamGrade
                FROM student_marks sm
                INNER JOIN user u ON sm.StudentID = u.UserID
                INNER JOIN courses c ON sm.CourseID = c.CourseID";
        $result = $conn->query($sql);
        
        // Display each grade in a table row
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['StudentID']."</td>";
                echo "<td>".$row['StudentName']."</td>";
                echo "<td>".$row['CourseName']."</td>";
                echo "<td>".$row['AssignmentGrade']."</td>";
                echo "<td>".$row['QuizGrade']."</td>";
                echo "<td>".$row['FinalExamGrade']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No grades found.</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Modal for adding/editing grade -->
<div id="addGradeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddGradeModal()">&times;</span>
        <h2>Add/Edit Grade</h2>
        <!-- Form for adding/editing grade -->
        <form id="gradeForm" action="editgrade.php" method="post">
            <div>
                <label for="studentID">Student ID:</label>
                <input type="text" id="studentID" name="student_id" required>
            </div>
            <div>
                <label for="courseID">Course ID:</label>
                <input type="text" id="courseID" name="course_id" required>
            </div>
            <!-- Form fields for each grade component -->
            <div>
                <label for="assignmentGrade">Assignment Grade:</label>
                <input type="number" id="assignmentGrade" name="assignment_grade" min="0" max="100" required>
            </div>
            <div>
                <label for="quizGrade">Quiz Grade:</label>
                <input type="number" id="quizGrade" name="quiz_grade" min="0" max="100" required>
            </div>
            <div>
                <label for="finalExamGrade">Final Exam Grade:</label>
                <input type="number" id="finalExamGrade" name="final_exam_grade" min="0" max="100" required>
            </div>
            <input type="submit" value="Save Grade">
        </form>
    </div>
</div>


    <!-- Modal for adding a new student -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddStudentModal()">&times;</span>
            <h2>Add New Student</h2>
            <form action="addstudent.php" method="post">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="text" name="student_id" placeholder="Student ID" required>
                <input type="text" name="email" placeholder="Email" required>
                <input type="text" name="mobile" placeholder="Mobile" required>
                <input type="password" name="password" placeholder="Password" required>
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <input type="date" name="birthday" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="submit" value="Add Student">
            </form>
        </div>
    </div>

    <!-- Modal for adding a new course -->
    <div id="addCourseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddCourseModal()">&times;</span>
            <h2>Add New Course</h2>
            <form action="addcourse.php" method="post">
                <input type="text" name="course_name" placeholder="Course Name" required>
                <input type="text" name="course_code" placeholder="Course Code" required>
                <input type="text" name="tutor" placeholder="Tutor" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="text" name="term" placeholder="Term" required>
                <input type="submit" value="Add Course">
            </form>
        </div>
    </div>
 
  <!-- Form to add a student to a course -->
  <div class="section" id="addDrop">
  <form action="manage_students_courses.php" method="post">
        <h3>Add Student to Course</h3>
    <label for="student_id_add">Student ID:</label>
    <input type="text" name="student_id" id="student_id_add" required>
    <label for="course_id_add">Course ID:</label>
    <input type="text" name="course_id" id="course_id_add" required>
    <input type="submit" name="add_student_to_course" value="Add Student to Course">
</form>
<!-- Form to drop a student from a course -->
<form action="manage_students_courses.php" method="post">
        <h3>Drop Student from Course</h3>
    <label for="student_id_drop">Student ID:</label>
    <input type="text" name="student_id" id="student_id_drop" required>
    <label for="course_id_drop">Course ID:</label>
    <input type="text" name="course_id" id="course_id_drop" required>
    <input type="submit" name="drop_student_from_course" value="Drop Student from Course">
</form>
</div>

<!-- Section to display courses and student enrollments -->
<div class="section" id="courseEnrollments">
    <h2>Course Enrollments</h2>
    <table>
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Number of Students</th>
            <th>Students</th>
        </tr>
        <?php
        // Include the database connection file
        require_once 'dbconn.php';

        // Retrieve all courses from the database
        $courseSql = "SELECT * FROM courses";
        $courseResult = $conn->query($courseSql);

        // Display each course along with its enrolled students
        if ($courseResult->num_rows > 0) {
            while ($courseRow = $courseResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$courseRow['CourseID']."</td>";
                echo "<td>".$courseRow['CourseName']."</td>";

                // Retrieve the number of students enrolled in the course
                $numStudentsSql = "SELECT COUNT(StudentID) AS num_students FROM student_courses WHERE CourseID='".$courseRow['CourseID']."'";
                $numStudentsResult = $conn->query($numStudentsSql);
                $numStudentsRow = $numStudentsResult->fetch_assoc();
                $numStudents = $numStudentsRow['num_students'];

                echo "<td>".$numStudents."</td>";

                // Retrieve the names of students enrolled in the course
                $studentsSql = "SELECT u.FirstName, u.LastName FROM user u INNER JOIN student_courses sc ON u.UserID = sc.StudentID WHERE sc.CourseID='".$courseRow['CourseID']."'";
                $studentsResult = $conn->query($studentsSql);

                echo "<td>";
                if ($studentsResult->num_rows > 0) {
                    $firstStudent = true; // Flag to check if it's the first student
                    while ($studentRow = $studentsResult->fetch_assoc()) {
                        // If it's not the first student, add a comma before displaying the name
                        if (!$firstStudent) {
                            echo ", ";
                        }
                        echo $studentRow['FirstName']." ".$studentRow['LastName'];
                        $firstStudent = false; // Update the flag
                    }
                } else {
                    echo "No students enrolled";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No courses found.</td></tr>";
        }
        ?>
    </table>
</div>


    <script>
        // Function to open the modal for adding a new student
        function openAddStudentModal() {
            document.getElementById("addStudentModal").style.display = "block";
        }

        // Function to close the modal for adding a new student
        function closeAddStudentModal() {
            document.getElementById("addStudentModal").style.display = "none";
        }

        // Function to open the modal for adding a new course
        function openAddCourseModal() {
            document.getElementById("addCourseModal").style.display = "block";
        }

        // Function to close the modal for adding a new course
        function closeAddCourseModal() {
            document.getElementById("addCourseModal").style.display = "none";
        }

        // Function to open the modal for adding/editing grade
        function openAddGradeModal() {
            document.getElementById("addGradeModal").style.display = "block";
        }

        // Function to close the modal for adding/editing grade
        function closeAddGradeModal() {
            document.getElementById("addGradeModal").style.display = "none";
        }

        // Function to confirm deletion of a student
        function deleteStudent(studentID) {
            if (confirm("Are you sure you want to delete this student?")) {
                // Redirect to manage_students.php with student ID for deletion
                window.location.href = "manage_students.php?delete_student=" + studentID;
            }
        }

        // Function to confirm deletion of a course
        function deleteCourse(courseID) {
            if (confirm("Are you sure you want to delete this course?")) {
                // Redirect to manage_courses.php with course ID for deletion
                window.location.href = "manage_courses.php?delete_course=" + courseID;
            }
        }

        // Function to edit grade
        function editGrade(studentID,
        courseID, assignmentGrades, quizGrade, finalExamGrade) {
            // Populate form fields with current grade information
            document.getElementById("editStudentID").value = studentID;
            document.getElementById("editCourseID").value = courseID;

            // Clear previous assignment fields
            document.getElementById("assignmentFields").innerHTML = "";

            // Populate assignment fields
            assignmentGrades.forEach(function(assignment) {
                var assignmentField = document.createElement("div");
                assignmentField.innerHTML = "<label>" + assignment.assignment_name + " Grade:</label>" +
                                             "<input type='number' name='assignment_grades[]' value='" + assignment.grade + "' min='0' max='100' required>";
                document.getElementById("assignmentFields").appendChild(assignmentField);
            });

            // Populate quiz and final exam grades
            document.getElementById("quizGrade").value = quizGrade;
            document.getElementById("finalExamGrade").value = finalExamGrade;

            // Open the modal for editing grade
            openAddGradeModal();
        }
        function scrollToSection(sectionId) {
    // Prevent the default anchor link behavior
    event.preventDefault();
    
    // Scroll to the specified section
    document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
}

    </script>
</body>
</html>