
<?php
session_start();

$loginFailedMessage = "";
if(isset($_SESSION['Login_Failed'])) {
    $loginFailedMessage = $_SESSION['Login_Failed'];
    unset($_SESSION['Login_Failed']);
}

$userName = "";
if(isset($_COOKIE['remember'])){
    $userName = $_COOKIE['remember'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>
<body>
<div id="login">
    <h2 class="text-center  pt-5">To-do List</h2>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="authenticate.php" method="post">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="username" value="<?php echo trim($userName);?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-info"><span><input id="remember-me" name="remember-me" value="remember" type="checkbox"></span><span>Remember me</span> </label><br>
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
                            <span style="color: red"><?= $loginFailedMessage; ?></span>
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="signup.php" class="text-info">Register here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const userName = '<?php echo $userName;?>';
            setRememberMeCheckBox(userName !== "");
        });
        function setRememberMeCheckBox(state){
            document.getElementById("remember-me").checked = state;
        }
    </script>
</div>
</body>
</html>
