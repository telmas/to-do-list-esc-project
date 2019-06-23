<?php

require_once 'app/init.php';
require_once("validateSession.php");

$projectsQuery = $db->prepare("
        Select *
        from project
        where name = :projectName
        and UserID = :userid
        limit 1
");
$projectsQuery->execute(['projectName' =>  $_POST['selectedProject'], 'userid' =>  $_SESSION['user_id']]);

$projects = $projectsQuery->rowCount()? $projectsQuery->fetchAll() : [];

if(isset($_POST['title'])){
    $title = trim($_POST['title']);
    $desc = trim($_POST['desc']);
    $completedate = $_POST['completedate'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'];
    $chosenProject  = $projects[0];
    $chosenProjectID =  $chosenProject[0];

    if(!empty($title)){
        $addedQuery = $db->prepare("
        INSERT INTO Task ( Title, Description, UserID, ProjectID, Category, Done, Difficulty, CreationDate, CompleteDate)
        VALUES (:title, :description, :userid, :projectID, :category, 0, :difficulty, NOW(), :completedate)
        ");
        $addedQuery->execute(['title' => $title,
                                'description' => $desc,
                                'userid' => $_SESSION['user_id'],
                                'projectID' => $chosenProjectID,
                                'category' =>  $category,
                                'difficulty' => $difficulty,
                                'completedate' =>  $completedate]);
    }
};
header('Location: home.php');
exit(0);

