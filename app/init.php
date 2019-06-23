<?php

try {
    $db = new PDO('mysql:dbname=todo;host=localhost;', 'root');
} catch (PDOException $e) {
    print "DB Connection Error!: " . $e->getMessage() . "<br/>";
    die();
}
