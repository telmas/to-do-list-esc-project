<?php
require_once 'app/init.php';
require_once("validateSession.php");

session_destroy();
session_unset();
unset($_SESSION["user_id"]);
$_SESSION = array();

header('Location: login.php');
exit(0);