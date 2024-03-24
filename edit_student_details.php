<?php
require('dbconn.php'); // Include the database connection file

// Check if the session is started and if the UserID session variable is set
if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    
    // Retrieve user details from the database
    $sql = "SELECT * FROM `user` WHERE UserID='$userID'";
    $result = $conn->query($sql);
    
    // Check if the query was successful and if there is at least one row returned
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $email = $row['EmailId'];
        $mobno = $row['MobNo'];
        $gender = $row['gender'];
        $educationLevel = $row['educationLevel'];
        $birthday = $row['birthday'];
        $mailingAddress = $row['mailingAddress'];
    } else {
        // If no rows were returned, set default values
        $firstName = $lastName = $email = $mobno = $gender = $educationLevel = $birthday = $mailingAddress = "";
    }
} else {
    // If UserID session variable is not set, display an error message
    echo "<p>Error: Session UserID not set.</p>";
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $mobno = $_POST['mobno'];
    $gender = $_POST['gender'];
    $educationLevel = $_POST['educationLevel'];
    $birthday = $_POST['birthday'];
    $mailingAddress = $_POST['mailingAddress'];

    // Update user details in the database
    $sql = "UPDATE `user` SET 
            `FirstName`='$firstName', 
            `LastName`='$lastName', 
            `EmailId`='$email', 
            `MobNo`='$mobno', 
            `gender`='$gender', 
            `educationLevel`='$educationLevel', 
            `birthday`='$birthday', 
            `mailingAddress`='$mailingAddress' 
            WHERE `UserID`='$userID'";
            
    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Details updated successfully!')</script>";
        header("Refresh:0.01; url=index.php", true, 303);
        exit; // Stop script execution after redirect
    } else {
        echo "<script type='text/javascript'>alert('Error updating details. Please try again.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details | Blackboard Student Portal</title>
   
    <style>
        .footer {
    background-color: #222; /* Dark background color */
    color: #fff; /* Text color */
    padding: 20px 0;
    text-align: center;
    flex-shrink: 0; /* Prevent the footer from shrinking */
}

       body {
            background-color: whitesmoke;
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
        .nav-avatar {
    width: 100px;
    height: 100px;
    background-image: url('profile2.png');
    background-size: cover;
    background-position: center;
    margin-left: 250px;
}
.wrapper {
    margin-top: 100px; /* Adjust the top margin to center the form vertically */
}

.form-horizontal {
    width: 60%; /* Set the width of the form */
    margin: auto; /* Center the form horizontally */
}

.form-horizontal .control-group {
    margin-bottom: 20px; /* Add margin between form elements */
}

.form-horizontal .control-label {
    font-weight: bold; /* Make labels bold */
}

.form-horizontal .controls {
    margin-left: 0; /* Reset the left margin for controls */
}

.form-horizontal input[type="text"],
.form-horizontal input[type="email"],
.form-horizontal input[type="tel"],
.form-horizontal select,
.form-horizontal textarea {
    width: 100%; /* Set the width of input fields */
    margin-bottom: 10px; /* Add margin below input fields */
}

.form-horizontal button[type="submit"] {
    width: 100%; /* Set the width of the button */
    margin-top: 20px; /* Add margin at the top */
    padding: 10px; /* Add padding */
    font-size: 16px; /* Adjust font size */
    background-color: #333; /* Button background color */
    color: #fff; /* Button text color */
    border: none; /* Remove button border */
    border-radius: 5px; /* Add border radius */
    cursor: pointer; /* Change cursor on hover */
}

.form-horizontal button[type="submit"]:hover {
    background-color: #555; /* Change background color on hover */
}
.module-head h3 {
    text-align: center; /* Center align the heading text */
}

    </style>
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <i class="icon-reorder shaded"></i>
                </a>
                <a class="brand" href="index.php" style="margin-left: 230px; font-size: 24px;">Blackboard Student Portal</a>
                <div class="nav-collapse collapse navbar-inverse-collapse">
                    <ul class="nav pull-right">
                        <li class="nav-user dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <div class="nav-avatar"></div>
    <b class="caret"></b>
</a>


                            <ul class="navbar">
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>><a href="profile.php">Profile</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>><a href="index.php">Dashboard</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'gradebook.php') echo 'class="active"'; ?>><a href="gradebook.php">Gradebook</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'course.php') echo 'class="active"'; ?>><a href="course.php">Courses</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="calender.php">Calender</a></li>
    <li <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="login.php">Logout</a></li>
</ul>
              
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span9">
                    <div class="module">
                        <div class="module-head">
                            <h3>Edit Details</h3>
                        </div>
                        <div class="module-body">
            

                <form class="form-horizontal" action="edit_student_details.php" method="post">
                <div class="control-group">
    <label class="control-label" for="firstName">First Name:</label>
    <div class="controls">
        <input type="text" id="firstName" name="firstName" value="<?php echo isset($firstName) ? $firstName : ''; ?>" required>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="lastName">Last Name:</label>
    <div class="controls">
        <input type="text" id="lastName" name="lastName" value="<?php echo isset($lastName) ? $lastName : ''; ?>" required>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="email">Email:</label>
    <div class="controls">
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="mobno">Mobile Number:</label>
    <div class="controls">
        <input type="tel" id="mobno" name="mobno" value="<?php echo isset($mobno) ? $mobno : ''; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="gender">Gender:</label>
    <div class="controls">
        <select id="gender" name="gender" required>
            <option value="male" <?php if (isset($gender) && $gender == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if (isset($gender) && $gender == 'female') echo 'selected'; ?>>Female</option>
        </select>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="educationLevel">Education Level:</label>
    <div class="controls">
        <input type="text" id="educationLevel" name="educationLevel" value="<?php echo isset($educationLevel) ? $educationLevel : ''; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="birthday">Birthday:</label>
    <div class="controls">
        <input type="date" id="birthday" name="birthday" value="<?php echo isset($birthday) ? $birthday : ''; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="mailingAddress">Mailing Address:</label>
    <div class="controls">
        <textarea id="mailingAddress" name="mailingAddress" rows="3"><?php echo isset($mailingAddress) ? $mailingAddress : ''; ?></textarea>
    </div>
</div>



                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" name="submit" class="btn btn-primary">Update Details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <b class="copyright">&copy; <?php echo date("Y"); ?> Blackboard Student Portal</b> All rights reserved.
        </div>
    </footer>

    <!--/.wrapper-->
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/common.js" type="text/javascript"></script>

    
</body>
</html>
