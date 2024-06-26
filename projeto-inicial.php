<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Luccas Arruda',
    new \DateTimeImmutable('2004-11-26')
);

echo $student->age() . PHP_EOL;
echo $student->name();