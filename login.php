<?php
require('dbconn.php');

if(isset($_POST['signin'])) {
    $u=$_POST['UserID'];
    $p=$_POST['Password'];

    $sql="SELECT * FROM user WHERE UserID='$u'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $x=$row['Password'];
    $y=$row['Type'];

    if($result->num_rows > 0 && strcasecmp($x, $p) == 0 && !empty($u) && !empty($p)) {
        $_SESSION['UserID']=$u;

        if ($y == 'student') {
            header('location:index.php');
        } else if ($y == 'admin') {
            header('location:admin.php');
        } 
    } else {
        echo "<script type='text/javascript'>alert('Failed to Login! Incorrect UserID or Password')</script>";
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
    <link rel="stylesheet" href="style.css" type="text/css" media="all">
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <!-- //Fonts -->
</head>
<body>
<h1>BLACKBOARD STUDENT PORTAL</h1>
    <div class="login">
        <h2>Sign In</h2>
        <form action="login.php" method="post">
            <input type="text" name="UserID" placeholder="UserID" required="">
            <input type="password" name="Password" placeholder="Password" required="">
            <div class="send-button">
                <input type="submit" name="signin" value="Sign In">
            </div>
            <div class="clear"></div>
        </form>
        <div class="sign-txt">Not yet member? <a href="signup.php">Sign up</a></div>
    </div> <!-- .login -->
    <div class="footer">
        <p>&copy; 2024 Blackboard Student Portal. All Rights Reserved</p>
    </div>
</body>
</html>