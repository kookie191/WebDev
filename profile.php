<?php
require('dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackboard Student Portal</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="student.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
        <style>
         .info-container {
            margin-right: 400px;
            width: 20%; /* Adjust width as needed */
            border: 1px solid #ccc;
        }

        .additional-details {
            width: 20%; /* Adjust width as needed */
            border: 1px solid #ccc;
            margin-left: 500px;
            margin-top: -225px;
        }
        .edit-button {
            text-align: center;
            margin-top: 80px;
            margin-left: 60px;
        }
        .edit-button .btn {
        background-color: #333;
        color: #fff;
        border-color: #333;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .edit-button .btn:hover {
        background-color: #555;
        border-color: #555;
    }
        </style>
</head>

<body>
   
 
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
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

                </div>
                <!--/.span3-->
                <div class="span9">
            <center>
                <img class="profile-img" src="profile2.png" alt="Profile Image">
            </center>
            <center>
                           <?php
                                if (isset($_SESSION['UserID'])) {
                                    $userID = $_SESSION['UserID'];
                                    $sql = "SELECT * FROM `user` WHERE UserID='$userID'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $firstName = $row['FirstName'];
                                        $lastName = $row['LastName'];
                                        $email = $row['EmailId'];
                                        $mobno = $row['MobNo'];
                                        $gender = $row['gender']; // Assuming 'Gender' is the column name for gender in the database
                                        $educationLevel = $row['educationLevel']; // Assuming 'EducationLevel' is the column name for education level in the database
                                        $birthday = $row['birthday']; // Assuming 'Birthday' is the column name for birthday in the database
                                        $mailingAddress = $row['mailingAddress']; // Assuming 'MailingAddress' is the column name for mailing address in the database
                                    } else {
                                        $firstName = $lastName = $email = $mobno = $gender = $educationLevel = $birthday = $mailingAddress = "Not available";
                                    }
                                } else {
                                    $firstName = $lastName = $email = $mobno = $gender = $educationLevel = $birthday = $mailingAddress = "Not available";
                                }
                            ?>
        <h1><?php echo $firstName ?> <?php echo $lastName ?></h1>
        <h3><?php echo $userID ?></h3>
        <div class="info-container">
    <h2>Main Information</h2>
        <p><strong>First Name:</strong> <?php echo $firstName ?></p>
        <p><strong>Last Name:</strong> <?php echo $lastName ?></p>
        <p><strong>Gender:</strong> <?php echo $gender ?></p>
        <p><strong>Email:</strong> <?php echo $email ?></p>
        <p><strong>User ID:</strong> <?php echo $userID ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $mobno ?></p>
        </div>

        <div class="additional-details">
    <h2>Additional Details</h2>
        <p><strong>Education Level:</strong> <?php echo $educationLevel ?></p>
        <p><strong>Birthday:</strong> <?php echo $birthday ?></p>
        <p><strong>Mailing Address:</strong> <?php echo $mailingAddress ?></p>
        </div>
                    </center>
                    <div class="edit-button">
                        <a href="edit_student_details.php" class="btn btn-primary">Edit Details</a>
                    </div>
                </div>
            </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <footer class="footer">
        <div class="container">
            <b class="copyright">&copy; 2024 Blackboard Student Portal </b>All rights reserved.
        </div>
    </footer>

    <!--/.wrapper-->
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="scripts/common.js" type="text/javascript"></script>

</body>

</html>
