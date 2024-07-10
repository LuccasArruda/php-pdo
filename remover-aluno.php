<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$databasePath");

$sqlDelete = 'DELETE FROM students WHERE ID = :id;';
$preparedStatement = $pdo->prepare($sqlDelete);
$preparedStatement->bindValue(':id', 4, PDO::PARAM_INT);
// $preparedStatement->bindValue(':id', 4, PDO::PARAM_INT); 
// é possível utilizar o mesmo preparedStatement mais de uma vez, apenas trocando os valores dos parâmetros
var_dump($preparedStatement->execute());