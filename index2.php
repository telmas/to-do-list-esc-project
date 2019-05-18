
<?php
require_once 'app/init.php';
require_once("validateSession.php");
include ('utils.php');

$tasksQuery = $db->prepare("
        Select id, title, description, done, completedate
        from task
        where userID = :userID
");

$tasksQuery->execute(['userID' => $_SESSION['user_id']]);

$tasks = $tasksQuery->rowCount()? $tasksQuery : [];

$projectsQuery = $db->prepare("
        Select id, userid, name
        from project
        where userID = :userID
");

$projectsQuery->execute(['userID' => $_SESSION['user_id']]);

$projects = $projectsQuery->rowCount()? $projectsQuery : [];
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--Icons link-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light+Two" rel="stylesheet">﻿
    <link rel="stylesheet" href="css/main.css">
    <meta  name="viewport" content="width=device-width, initial-scale=1.0"
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>To Do</title>
</head>
<body>
<div class="container p-5">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4 text-center text-white" style="background-color: RGB(53,134,153)">
            <br>
            <p class="lead"><h1>To Do <i class="fas fa-check-double"></i></h1>
            <div><p>Keep track of your tasks</p></div>
            <br>
            <br>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-8" style="color: RGB(53,134,153)"  >
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4><i class="fas fa-tasks"></i>  Tasks </h4>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php foreach($tasks as $task): ?>
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">
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
                                        <span class="badge badge-info">
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
                                        <p class="mb-1">
                                            <?php if($task['done'] == 1): ?>
                                            <s>
                                                <?php endif; ?>
                                                <small><?php echo $task['description']; ?></small>
                                                <?php if($task['done'] == 1): ?>
                                            </s>
                                        <?php endif; ?>
                                        </p>
                                        <?php if($task['done'] == 0): ?>
                                            <a href="mark.php?as=done&task=<?php echo $task['id']?>" class="btn btn-info">Mark as done</a>
                                        <?php endif; ?>
                                        <a href="deleteTask.php?as=delete&task=<?php echo $task['id']?>" class="btn btn-danger">Delete</a>
                                    </a>
                                </div>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4><i class="fas fa-tasks"></i> Add Task </h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <form action="addTask.php" method="post">
                                <div class="form-group ">
                                    <h1>Add Task</h1>
                                    <label for="inputTask">Task:</label>
                                    <input type="text" name="title" class="form-control" id="inputTask"  placeholder="Task" autocomplete="off" required><br>

                                    <label for="inputDescription">Description:</label>
                                    <input type="text" name="desc"  class="form-control" id="inputDescription" autocomplete="off"  placeholder="Task Description" required><br>

                                    <label for="inputDueDate">Due Date:</label>
                                    <input type="date" name="completedate" class="form-control" id="inputDueDate" autocomplete="off" required><br>

                                    <label for="selectedProject">Select project:</label>
                                    <select class="form-control" id="selectedProject" name="selectedProject" required>
                                        <?php foreach($projects as $project): ?>
                                            <option><?php echo $project['name']; ?></option>
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
                                <input type="submit" value="Add" class="btn-default" style="width:100%"">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4><i class="fas fa-tasks"></i> Add Project</h4>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <form  action="addProject.php" method="post">
                                <div class="form-group ">
                                    <h1>Add Project</h1>
                                    <label for="inputTask">Project Name:</label>
                                    <input type="text" name="newProjectName" class="form-control" id="inputProjectName"  placeholder="Project Name" autocomplete="off" required><br>
                                </div>
                                <input type="submit" value="Add Project" class="btn-default" style="width:100%"">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
