<?php
session_start();
require_once("app/init.php");

$username = htmlentities($_POST['username']);
$password = htmlentities($_POST['password']);

$usersQuery = $db->prepare("
       SELECT id, username FROM user WHERE username=:username AND password=:password;");
$usersQuery->execute(['username' =>  $username, 'password' => $password]);

$users = $usersQuery->rowCount()? $usersQuery->fetchAll() : [];

if(count($users) > 0) {
    $row = $users[0];

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['userName'] = $row['username'];

    if($_POST["remember-me"] == "remember"){
        setcookie ("remember", $row['username']);
    } else {
        setcookie ("remember","");
    }

    header("Location: home.php");
    die();
}  else {
    $_SESSION['Login_Failed'] = "Username or password are wrong. Please enter valid input";
    header("Location: login.php");
    die();
}