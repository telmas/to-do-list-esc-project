<?php

try {
    $db = new PDO('mysql:dbname=todo2;host=localhost;', 'root');
} catch (PDOException $e) {
    print "DB Connection Error!: " . $e->getMessage() . "<br/>";
    die();
}
