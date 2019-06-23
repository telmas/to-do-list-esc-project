<?php

require_once 'app/init.php';
require_once("validateSession.php");

if(isset($_POST['newProjectName'])){
    $projectName = trim($_POST['newProjectName']);

    if(!empty($projectName)){
        $addedQuery = $db->prepare("
        INSERT INTO Project (UserID, Name)
        VALUES (:userid, :name)
        ");
        $addedQuery->execute([
            'userid' => $_SESSION['user_id'],
            'name' =>   $projectName]);
    }
};
header('Location: home.php');
exit(0);

