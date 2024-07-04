<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$databasePath");

$statement = $pdo->query('SELECT * FROM students');
$studentsDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentsList = [];

foreach ($studentsDataList as $studentData) {
    $studentName = $studentData['name'];
    echo $studentName . PHP_EOL;
    $studentId = $studentData['id'];
    $studentBirthDate = new DateTimeImmutable($studentData['birth_date']);
    
    $studentsList[] = new Student(
        $studentId,
        $studentName,
        $studentBirthDate
    );
}

var_dump($studentsList);
