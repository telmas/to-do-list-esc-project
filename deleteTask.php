<?php

require_once 'app/init.php';
require_once("validateSession.php");

if(isset($_GET['as'], $_GET['task'])) {
    $as = $_GET['as'];
    $task = $_GET['task'];

    switch ($as) {
        case 'delete':
            $doneQuery = $db->prepare("
            DELETE from Task 
            WHERE 1 = 1
            AND ID = :taskID
            AND UserID = :userID");

            $doneQuery->execute(['taskID' => $task, 'userID' => $_SESSION['user_id']]);
            break;
    }
    header('Location: index2.php');
}
exit(0);
