
<?php
require_once 'app/init.php';
require_once("validateSession.php");
include ('utils.php');

$projectFilter = "";
$difficultyFilter = "";
$categoryFilter = "";
$progressFilter = "";


if(isset($_POST['difficultyFilter']) && $_POST['difficultyFilter'] != -1){
    $difficultyFilter = " and difficulty = "  . $_POST['difficultyFilter']. " ";
}
if(isset($_POST['categoryFilter']) && $_POST['categoryFilter'] != -1){
    $categoryFilter = " and category = " . $_POST['categoryFilter'] . " ";
}
if(isset($_POST['progressFilter']) && $_POST['progressFilter'] != -1) {
    $progressFilter = " and done = " . $_POST['progressFilter'] . " ";
}

if (isset($_POST['selectedProjectToFilter']) && trim($_POST['selectedProjectToFilter']) != "All") {

    $projectIdFilterQuery = $db->prepare("
        Select *
        from project
        where name = :projectName
        and UserID = :userid
        limit 1
");
    $projectIdFilterQuery->execute(['projectName' => $_POST['selectedProjectToFilter'], 'userid' => $_SESSION['user_id']]);

    $selectedProjectFilter = $projectIdFilterQuery->rowCount() ? $projectIdFilterQuery->fetchAll() : [];
    $chosenProject = $selectedProjectFilter[0];
    $chosenProjectID = $chosenProject[0];
    $projectFilter = " and projectID = " . $chosenProjectID . " ";

}
$tasksQuery = $db->prepare("
        Select id, title, description, projectID, category, done, difficulty, cast(creationDate as date) as creationDate, completedate
        from task
        where userID = :userID".
    $projectFilter .
    $difficultyFilter.
    $categoryFilter .
    $progressFilter);

$tasksQuery->execute(['userID' => $_SESSION['user_id']]);

$tasks = $tasksQuery->rowCount()? $tasksQuery : [];

$projectsQuery = $db->prepare("
        Select id, userid, name
        from project
        where userID = :userID
");

$projectsQuery->execute(['userID' => $_SESSION['user_id']]);
$projects = $projectsQuery->rowCount()? $projectsQuery : [];
$projects2 = array();
$projects3 = array();
$projects4 = array();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light+Two" rel="stylesheet">﻿
    <meta  name="viewport" content="width=device-width, initial-scale=1.0"
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js">
    </script>
    <title>To Do</title>
    <style>
        .button1 {
            width:100%;
        }
        .button2 {
            width:100%;
        }
        .button3 {
            width:100%;
        }
    </style>
</head>
<body>
<div id="home" class="container p-4">
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-5 text-center text-white card" style="background-color: RGB(53,134,153)">
            <form action="home.php" id="filterForm" onsubmit="return false" method="post">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4 text-left text-white" style="background-color: RGB(53,134,153)">
                        <br>
                        <a class="navbar-brand text-white" href="userProfile.php"><i class="far fa-user-circle"></i> Profile</a>
                        <a class="navbar-brand text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-center text-white" style="background-color: RGB(53,134,153)">
                        <p class="lead"><h1>To Do <i class="fas fa-check-double"></i></h1>
                        <div><p>Keep track of your tasks</p></div>
                        <br>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 text-left text-white" style="background-color: RGB(53,134,153)">
                        <label for="selectedProjectToFilter">Project:</label>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-center text-white" style="background-color: RGB(53,134,153)">
                        <select class="form-control" id="selectedProjectToFilter" name="selectedProjectToFilter" required>
                            <option><?php echo "All"; ?></option>
                            <?php foreach($projects as $project): ?>
                                <option><?php echo $project['name']; ?></option>
                                <?php array_push($projects2, $project); ?>
                                <?php array_push($projects3, $project); ?>
                                <?php array_push($projects4, $project); ?>
                            <?php endforeach; reset($projects); unset($project);?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 text-left text-white" style="background-color: RGB(53,134,153)">
                        <p>Difficulty:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-center text-white" style="background-color: RGB(53,134,153)">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <input type="radio" name="difficultyFilter" id="difficultyFilterOptionMinusOne" value=-1 required autocomplete="off" checked> All
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="difficultyFilter" id="difficultyFilterOption0" value=0 required autocomplete="off"> Easy
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="difficultyFilter" id="difficultyFilterOption1" value=1 required autocomplete="off"> Normal
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="difficultyFilter" id="difficultyFilterOption2" value=2 required autocomplete="off"> Hard
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 text-left text-white" style="background-color: RGB(53,134,153)">
                        <p>Progress:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-center text-white" style="background-color: RGB(53,134,153)">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <input type="radio" name="progressFilter" id="progressFilterOptionMinusOne" value=-1 required autocomplete="off" checked> All
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="progressFilter" id="progressFilterOption0" value=0 required autocomplete="off"> Unfinished
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="progressFilter" id="progressFilterOption1" value=1 required autocomplete="off"> Done
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 text-left text-white" style="background-color: RGB(53,134,153)">
                        <p>Category:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-center text-white" style="background-color: RGB(53,134,153)">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <input type="radio" name="categoryFilter" id="categoryFilterOptionMinusOne" value=-1 required autocomplete="off" checked> All
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="categoryFilter" id="categoryFilterOption0" value=0 required autocomplete="off"> Home
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="categoryFilter" id="categoryFilterOption1" value=1 required autocomplete="off"> Work
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <input type="submit" value="Filter"  class="btn btn-light btn-block"/>
                <br>
            </form>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-7" style="color: RGB(53,134,153)"  >
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 style="color:RGB(53,134,153);"><i class="fas fa-tasks"></i>  Tasks </h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php foreach($tasks as $task): ?>
                                <div id="listItem<?php echo $task['id']?>" class="list-group">
                                    <a class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="modal" data-target="#listItemModal<?php echo $task['id']?>">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 id="taskTitle<?php echo $task['id']?>" class="mb-1">
                                                <?php if($task['done'] == 1): ?>
                                                <s>
                                                    <?php endif; ?>
                                                    <?php echo $task['title']; ?>
                                                    <?php if($task['done'] == 1): ?>
                                                </s>
                                            <?php endif; ?>
                                            </h5>
                                            <?php if($task['done'] == 0): ?>
                                                <small>
                                                    <span ID="deadline<?php echo $task['id']?>" class="badge badge-info">
                                                        <?php
                                                        $datetime1 = new DateTime();
                                                        try {
                                                            $datetime2 = new DateTime($task['completedate']);
                                                        } catch (Exception $e) {
                                                            $datetime2 = new DateTime();
                                                        }
                                                        echo ago($datetime2);
                                                        ?>
                                                    </span>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                        <p id="taskDescription<?php echo $task['id']?>" class="mb-1">
                                            <?php if($task['done'] == 1): ?>
                                            <s>
                                                <?php endif; ?>
                                                <small><?php echo $task['description']; ?></small>
                                                <?php if($task['done'] == 1): ?>
                                            </s>
                                        <?php endif; ?>
                                        </p>
                                    </a>
                                    <?php if($task['done'] == 0): ?>
                                        <button id="markAsDoneButton<?php echo $task['id']?>" type="button"  class="btn btn-info button1" value="<?php echo $task['id']?>" >Mark as done</button>
                                    <?php endif; ?>
                                    <button id="deleteButton<?php echo $task['id']?>" type="button"  value="<?php echo $task['id']?>" class="btn btn-danger button2">Delete</button>
                                </div>
                                <br>
                                <div class="modal fade" id="listItemModal<?php echo $task['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle">Task title: <?php echo $task['title']?></h5>
                                                <br>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="modal-desc" id="modalDesc">  Description: <?php echo $task['description']?></h6>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-center text-white list-group-item list-group-item-action flex-column align-items-start" style="background-color: RGB(53,134,153)">
                                                        <h6 class="modal-desc" id="modalProject"><?php
                                                            $item = "No project";
                                                            foreach($projects3 as $project1) {
                                                                if ($task['projectID'] == $project1['id']) {
                                                                    $item = $project1['name'];
                                                                    break;
                                                                }
                                                            }
                                                            echo 'Project: '.$item;
                                                            reset($projects3);
                                                            ?></h6>
                                                        <h6 class="modal-desc" id="modalCategory">Category: <?php
                                                            switch($task['category']){
                                                                case 0:
                                                                    echo 'Home';
                                                                    break;
                                                                case 1:
                                                                    echo 'Work';
                                                                    break;
                                                                default:
                                                                    echo 'No Category';
                                                                    break;
                                                            }?></h6>
                                                        <h6 class="modal-desc" id="modalDifficulty">Difficulty: <?php
                                                            switch($task['difficulty']){
                                                                case 0:
                                                                    echo 'Easy';
                                                                    break;
                                                                case 1:
                                                                    echo 'Normal';
                                                                    break;
                                                                case 2:
                                                                    echo 'Hard';
                                                                    break;
                                                                default:
                                                                    echo 'No Difficulty';
                                                                    break;
                                                            }?></h6>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-center text-white list-group-item list-group-item-action flex-column align-items-start" style="background-color: RGB(53,134,153)">
                                                        <h6 class="modal-desc" id="modalCreationDate">Created on: <?php echo $task['creationDate']?></h6>
                                                        <h6 class="modal-desc" id="modalProgress">Progress: <?php
                                                            switch($task['done']){
                                                                case 0:
                                                                    echo 'Unfinished';
                                                                    break;
                                                                case 1:
                                                                    echo 'Done';
                                                                    break;
                                                                default:
                                                                    echo 'No Progress Data';
                                                                    break;
                                                            } ?></h6>
                                                        <?php if($task['done'] == 0): ?>
                                                            <h6 class="modal-desc" id="modalProgress">Deadline:
                                                                <?php
                                                                $datetime1 = new DateTime();
                                                                try {
                                                                    $datetime2 = new DateTime($task['completedate']);
                                                                } catch (Exception $e) {
                                                                    $datetime2 = new DateTime();
                                                                }
                                                                echo ago($datetime2);
                                                                ?></h6>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 style="color:RGB(53,134,153);"><i class="fas fa-angle-double-right"></i>  Add Task </h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <form action="addTask.php" method="post">
                                <div class="form-group ">
                                    <label for="inputTask">Task:</label>
                                    <input type="text" name="title" class="form-control" id="inputTask"  placeholder="Task" autocomplete="off" required><br>

                                    <label for="inputDescription">Description:</label>
                                    <input type="text" name="desc"  class="form-control" id="inputDescription" autocomplete="off"  placeholder="Task Description" required><br>
                                    <label for="inputDueDate">Due Date:</label>
                                    <input type="date" name="completedate" class="form-control" id="inputDueDate" autocomplete="off" required><br>
                                    <label for="selectedProject">Select project:</label>
                                    <select class="form-control" id="selectedProject" name="selectedProject" required>
                                        <?php foreach($projects2 as $project2): ?>
                                            <option><?php echo $project2['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="mt-3" for="customRange3">Difficulty:</label>
                                    <div class="row justify-content-between p-3">
                                        <div>Easy</div>
                                        <div>Normal</div>
                                        <div>Hard</div>
                                    </div>
                                    <input type="range" class="custom-range" name="difficulty" min="0" max="2" step="1" id="customRange3" required>

                                    <label>Category:</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline4" name="category" value=0 required class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline4">Home</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline5" name="category" value=1 class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline5">Work</label>
                                    </div>
                                    <br>
                                </div>
                                <input type="submit" value="Add" class="btn btn-info btn-default" style="width:100%"">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h4 style="color:RGB(53,134,153);"><i class="fas fa-project-diagram"></i>  Projects </h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            <?php foreach($projects4 as $focusedProject): ?>
                                <div id="listProjectItem<?php echo $focusedProject['id']?>" class="list-group">
                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 id="projectName<?php echo $focusedProject['id']?>" class="mb-1"><?php echo $focusedProject['name']; ?></h5>
                                        </div>
                                    </div>
                                    <button id="deleteProjectButton<?php echo $focusedProject['id']?>" type="button" value="<?php echo $focusedProject['id']?>" class="btn btn-danger button3">Delete</button>
                                </div>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4 style="color:RGB(53,134,153);"><i class="fas fa-angle-right"></i>  Add Project</h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <form  action="addProject.php" method="post">
                                <div class="form-group ">
                                    <label for="inputTask">Project Name:</label>
                                    <input type="text" name="newProjectName" class="form-control" id="inputProjectName"  placeholder="Project Name" autocomplete="off" required><br>
                                </div>
                                <input type="submit" value="Add Project" class="btn btn-info btn-default" style="width:100%"">
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script >
    window.onload = function() {
        if (window.jQuery) {
            // jQuery is loaded
            console.log("Works!");
        } else {
            // jQuery is not loaded
            console.log("Doesn't Work");
        }
    };

    jQuery(".button1").click(function() {
        let taskID = jQuery(this).attr("value");
        markAsDoneFunction(taskID)
    });

    jQuery(".button2").click(function() {
        let taskID = jQuery(this).attr("value");
        deleteTaskFunction(taskID);
    });

    jQuery(".button3").click(function() {
        let projectID = jQuery(this).attr("value");
        deleteProjectFunction(projectID);
    });

    function markAsDoneFunction(taskID) {
        let URL = "markAsDone.php?as=done&task="+taskID;
        let reload = false;
        $.getJSON(URL, function (data) {
            if(data.title!==true){
                alert("Something went wrong.");
            } else {
                $('#markAsDoneButton'+taskID).fadeOut(500, function () {
                    $('#markAsDoneButton'+taskID).remove();
                });
                $('#taskDescription'+taskID).fadeOut(500, function () {
                    $('#taskDescription'+taskID).html('<s>' +$('#taskDescription'+taskID).html() + '</s>');
                });
                $('#taskTitle'+taskID).fadeOut(500, function () {
                    $('#taskTitle'+taskID).html('<s>' +$('#taskTitle'+taskID).html() + '</s>');
                });
                $('#deadline'+taskID).fadeOut(500, function () {
                    $('#deadline'+taskID).remove();
                });
                $('#taskTitle'+taskID).fadeIn(500);
                $('#taskDescription'+taskID).fadeIn(500);
            }
        });
    }

    function deleteTaskFunction(taskID) {
        let URL = "deleteTask.php?as=delete&task="+taskID;
        $('#listItem'+taskID).fadeOut(500, function () {
            $.getJSON(URL, function (data) {
                if(data.title!==true){
                    alert("Something went wrong.");
                } else {
                    $('#listItem'+taskID).remove();
                }
            });
        });
    }

    function deleteProjectFunction(projectID) {
        let URL = "deleteProject.php?as=delete&project=" + projectID;
        $('#listProjectItem' + projectID).fadeOut(500, function () {
            $.getJSON(URL, function (data) {
                if(data.title!==true){
                    alert("Something went wrong.");
                } else {
                    $('#listProjectItem' + projectID).remove();
                    $('#accordion').load('home.php' + ' #accordion', function () {
                        jQuery(".button1").click(function() {
                            let taskID = jQuery(this).attr("value");
                            markAsDoneFunction(taskID)
                        });

                        jQuery(".button2").click(function() {
                            let taskID = jQuery(this).attr("value");
                            deleteTaskFunction(taskID);
                        });

                        jQuery(".button3").click(function() {
                            let projectID = jQuery(this).attr("value");
                            deleteProjectFunction(projectID);
                        });
                    });
                    $('#filterForm').load('home.php' + ' #filterForm');
                }
            });
        });

    }

    $('#filterForm').submit(function(event){
        $('#accordion').fadeOut(500, function () {
            $.ajax({
                url: 'home.php',
                type: 'post',
                dataType:'html',
                data: $('#filterForm').serialize(),
                success: function(response, textStatus, jqXHR){
                    $('#accordion').html($(response).find("#accordion"));
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('error(s):'+textStatus, errorThrown);
                }
            }).done(function () {
                jQuery(".button1").click(function() {
                    let taskID = jQuery(this).attr("value");
                    markAsDoneFunction(taskID)
                });

                jQuery(".button2").click(function() {
                    let taskID = jQuery(this).attr("value");
                    deleteTaskFunction(taskID);
                });

                jQuery(".button3").click(function() {
                    let projectID = jQuery(this).attr("value");
                    deleteProjectFunction(projectID);
                });
            });
        });
        $('#accordion').fadeIn(500);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
