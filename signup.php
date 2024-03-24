<?php
require('dbconn.php');

if(isset($_POST['signup'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $mobno = $_POST['PhoneNumber'];
    $userID = $_POST['UserID'];

    $check_sql = "SELECT * FROM user WHERE UserID='$userID'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script type='text/javascript'>alert('User Already Exists')</script>";
    } else {
        // SQL query to insert user data
        $sql = "INSERT INTO user (FirstName, LastName, EmailId, MobNo, UserID, Password) VALUES ('$firstName', '$lastName', '$email', '$mobno', '$userID', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Registration Successful')</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error Occurred. Please try again.')</script>";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<!-- Head -->
<head>
    <title>Blackboard Student Portal</title>
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Blackboard Student Portal, Student Login Form, Responsive Login Form, HTML Login, CSS, JavaScript" />
    <!-- //Meta-Tags -->
    <!-- Style --> <link rel="stylesheet" href="style2.css" type="text/css" media="all">
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <!-- //Fonts -->
</head>
<!-- //Head -->
<!-- Body -->
<body>
    <h1>BLACKBOARD STUDENT PORTAL</h1>
        <div class="register">
            <h2>Sign Up</h2>
            <form action="login.php" method="post">
                <input type="text" name="FirstName" placeholder="First Name" required>
                <input type="text" name="LastName" placeholder="Last Name" required>
                <input type="text" name="UserID" placeholder="User ID" required="">
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
                
                <div class="send-button">
                    <input type="submit" name="signup" value="Sign Up">
                </div>
                <p>By creating an account, you agree to our <a class="underline" href="terms.html">Terms</a></p>
                <p>Already have an account? <a href="login.php" class="login-link">Log in</a></p>
                <div class="clear"></div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="footer w3layouts agileits">
        <p> &copy; 2024 Blackboard Student Portal. All Rights Reserved </a></p>
    </div>
</body>
<!-- //Body -->
</html>
