<?php
require_once 'app/init.php';
require_once("validateSession.php");

$userInfoQuery = $db->prepare("
select user.ID, user.username as Username,  CAST(user.RegistrationDate as DATE) RegistrationDate, user.Email,
       count(distinct project.id) NumberOfProjects, count(distinct task.ID) NumberOfTasks,
       count(distinct easyTask.ID) EasyTasks, count(distinct normalTask.ID) NormalTasks, count(distinct hardTask.ID) HardTasks,
       count(distinct homeTask.ID) HomeTasks, count(distinct workTask.ID) WorkTasks,
       count(distinct unfinishedTask.ID) UnfinishedTasks, count(distinct doneTask.ID) DoneTasks
     from user
    left join project on project.UserID = user.ID
    left join task on task.UserID = user.ID
    left join task as easyTask on easyTask.UserID = user.ID and easyTask.Difficulty = 0
    left join task as normalTask on normalTask.UserID = user.ID and normalTask.Difficulty = 1
    left join task as hardTask on hardTask.UserID = user.ID and hardTask.Difficulty = 2
    left join task as homeTask on homeTask.UserID = user.ID and homeTask.Category = 0
    left join task as workTask on workTask.UserID = user.ID and workTask.Category = 1
    left join task as unfinishedTask on unfinishedTask.UserID = user.ID and unfinishedTask.Done = 0
    left join task as doneTask on doneTask.UserID = user.ID and doneTask.Done = 1
where user.id = :userID
group by user.ID, user.username,  user.RegistrationDate, user.Email;
");

$userInfoQuery->execute(['userID' => $_SESSION['user_id']]);

$userInfo = $userInfoQuery->rowCount()? $userInfoQuery : [];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>User Profile</title>
</head>
<body>
<div class="container p-5">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-3"  style="color: RGB(53,134,153)" >
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 text-center text-white card" style="background-color: RGB(53,134,153)">
            <br>
            <span>
                <a class="navbar-brand text-white" href="home.php"><i class="fas fa-home"></i> Home</a>
                <a class="navbar-brand text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <p class="lead center">User Profile</p>
                <img src="backgrounds/material-white.jpg" width="150" height="150" class="rounded-circle" alt="Profile Image">
            </span>
            <?php foreach($userInfo as $userInfo1): ?>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center text-white" style="background-color: RGB(53,134,153)">
                    <p><?php echo 'Username: '. $userInfo1['Username']; ?></p>
                    <p><?php echo 'Email: '. $userInfo1['Email']; ?></p>
                    <p><?php echo 'Registration Date: '.$userInfo1['RegistrationDate']; ?></p>
                    <p><?php echo 'Nr. of tasks: '.$userInfo1['NumberOfTasks']; ?></p>
                    <p><?php echo 'Nr. of projects: '.$userInfo1['NumberOfProjects']; ?></p>
                    <p><?php echo 'Nr. of unfinished tasks: '.$userInfo1['UnfinishedTasks'];?></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-center text-white" style="background-color: RGB(53,134,153)">
                    <p><?php echo 'Nr. of easy tasks: '.$userInfo1['EasyTasks']; ?></p>
                    <p><?php echo 'Nr. of normal tasks: '.$userInfo1['NormalTasks']; ?></p>
                    <p><?php echo 'Nr. of hard tasks: '. $userInfo1['HardTasks']; ?></p>
                    <p><?php echo 'Nr. of home tasks: '. $userInfo1['HomeTasks']; ?></p>
                    <p><?php echo 'Nr. of work tasks: '. $userInfo1['WorkTasks']; ?></p>
                    <p><?php echo 'Nr. of done tasks: '.$userInfo1['DoneTasks']; ?></p>
                </div>
                <?php break; endforeach;?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3"  style="color: RGB(53,134,153)" >
            </div>
            <br>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
