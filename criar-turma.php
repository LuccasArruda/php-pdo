<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction(); 

try {
    $student = new Student(null, 'Luccas', new DateTimeImmutable('2004-11-26'));
    $studentRepository->save($student);

    $newStudent = new Student(null, 'Jeferson Jovem', new DateTimeImmutable('2006-11-23'));
    $studentRepository->save($newStudent);
    
    $connection->commit();

} catch(RuntimeException $error) {
    echo $error->getMessage();
    $connection->rollBack();
}

