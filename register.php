<?php
session_start();

require_once("app/init.php");

$username = htmlentities($_POST['username']);
$email = htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);
$confirmPassword = htmlentities($_POST['confirmPassword']);

$existingUserNamesQuery = $db->prepare("
       SELECT * FROM user WHERE username=:username;");
$existingUserNamesQuery->execute(['username' =>  $username]);
$users = $existingUserNamesQuery->rowCount()? $existingUserNamesQuery->fetchAll() : [];

$existingEmailsQuery = $db->prepare("
       SELECT * FROM user WHERE  email=:email;");
$existingEmailsQuery->execute(['email' =>  $email]);
$emails = $existingEmailsQuery->rowCount()? $existingEmailsQuery->fetchAll() : [];

if(count($emails) > 0) {
    $_SESSION['Registration_Message'] = "Email has already been used. Please enter valid input";
    header("Location: signup.php");
    die();
} else if (count($users) > 0) {
    $_SESSION['Registration_Message'] = "Username has already been used. Please enter valid input";
    header("Location: signup.php");
    die();
} else if($password !=  $confirmPassword){
    $_SESSION['Registration_Message'] = "Passwords do not match. Please enter valid input";
    header("Location: signup.php");
    die();
} else {
    $registerUserQuery = $db->prepare("
       INSERT INTO user(Username, Password, RegistrationDate, Email)
        VALUES (:username, :password,  NOW(), :email)");
    $registerUserQuery->execute(['username' =>  $username, 'password' => $password, 'email' =>  $email]);


    $usersQuery = $db->prepare("
       SELECT id, username FROM user WHERE username=:username AND password=:password;");
    $usersQuery->execute(['username' =>  $username, 'password' => $password]);

    $users = $usersQuery->rowCount()? $usersQuery->fetchAll() : [];
    if(count($users) > 0) {
        $row = $users[0];

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['userName'] = $row['username'];

        header("Location: index2.php");
        die();
    }
}
