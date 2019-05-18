<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['Login_Failed'] = "Login is required";
    header("Location: login.php");
    die();
}

$user_id = $_SESSION['user_id'];
