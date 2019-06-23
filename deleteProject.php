<?php

require_once 'app/init.php';
require_once("validateSession.php");

if(isset($_GET['as'], $_GET['project'])) {
    $as = $_GET['as'];
    $project = $_GET['project'];

    switch ($as) {
        case 'delete':
            $doneQuery = $db->prepare("
            DELETE from Project 
            WHERE 1 = 1
            AND ID = :projectID
            AND UserID = :userID");

            $doneQuery->execute(['projectID' => $project, 'userID' => $_SESSION['user_id']]);
            break;
    }
    $arr = [
        "title" => true
    ];

    $outputJSON = json_encode($arr);
    echo $outputJSON;
}
