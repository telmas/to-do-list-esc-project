<?php
require_once 'app/init.php';
require_once("validateSession.php");

if(isset($_GET['as'], $_GET['task'])){
    $as = $_GET['as'];
    $task = $_GET['task'];

    switch($as){
        case 'done':
            $doneQuery = $db->prepare("
            UPDATE Task 
            SET Done = 1
            WHERE ID = :taskID
            AND UserID = :userID");

            $doneQuery->execute(['taskID' => $task, 'userID' => $_SESSION['user_id']]);
            break;
    }
    $arr = [
        "title" => true
    ];

    $outputJSON = json_encode($arr);
    echo $outputJSON;
}
