<?php

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$databasePath");

$statement = $pdo->query('SELECT * FROM students');
$studentsList = $statement->fetchAll();

echo $studentsList[0]['name'];