
<?php
session_start();

$registrationMessage = "";
if(isset($_SESSION['Registration_Message'])) {
    $registrationMessage = $_SESSION['Registration_Message'];
    unset($_SESSION['Registration_Message']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Signup</title>

</head>
<body>

<div id="signup">
    <h2 class="text-center  pt-5">To-do List</h2>
    <div class="container">
        <div id="signup-row" class="row justify-content-center align-items-center">
            <div id="signup-column" class="col-md-6">
                <div id="signup-box" class="col-md-12">
                    <form id="signup-form" class="form" action="register.php" method="post">
                        <h3 class="text-center text-info">Sign Up</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="username" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-info">Email:</label><br>
                            <input type="email" name="email" id="email" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="text-info">Confirm Password:</label><br>
                            <input type="password" name="confirmPassword" id="confirmPassword" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-info"> <span><input id="remember-me" value="remember" name="remember-me" type="checkbox"></span><span>Remember me</span></label><br>
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="Sign Up">
                            <span style="color: red"><?= $registrationMessage; ?></span>

                        </div>
                        <div id="login-link" class="text-right">
                            <a href=login.php class="text-info">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>





