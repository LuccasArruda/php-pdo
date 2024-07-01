<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$caminhoBanco = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$caminhoBanco");

$student = new Student(null, 'Maria Fernanda', new DateTimeImmutable('1982-11-30'));
$studentName = $student->name();
$studentBirthDate = $student->birthDate()->format('Y-m-d');


$sqlInsert = "INSERT INTO students (name, birth_date) VALUES ('$studentName','$studentBirthDate');";

var_dump($pdo->exec($sqlInsert));