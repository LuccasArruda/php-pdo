<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Domain\Model\Student;
use DateTimeImmutable;
use PDO;
use PDOStatement;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array
    {
        $sqlSelectAll = 'SELECT * FROM students';
        $preparedStatement = $this->connection->query($sqlSelectAll);
        return $this->hydrateStudentList($preparedStatement);        
    }
    
    public function hydrateStudentList(PDOStatement $preparedStatement): array {
        $studentDataList = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];
        
        foreach ($studentDataList as $student){
            $studentList[] = new Student(
                $student['id'],
                $student['name'],
                new DateTimeImmutable($student['birth_date'])
            );
        }
        return $studentList;
    }

    public function studentsBornAt(DateTimeInterface $birthDate): array
    {
        $sqlQueryBirthDate = 'SELECT * FROM students WHERE birth_date = :birth_date';
        $preparedStatement = $this->connection->prepare($sqlQueryBirthDate);
        $preparedStatement->bindValue(':birth_date', $birthDate->format('Y-m-d'));
        $preparedStatement->execute();

        return $this->hydrateStudentList($preparedStatement);
    }

    public function insert(Student $student): bool
    {
        $sqlInsert = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $preparedStatement = $this->connection->prepare($sqlInsert);

        $success = $preparedStatement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    public function update(Student $student): bool
    {  
        $sqlUpdate = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id';
        $preparedStatement = $this->connection->prepare($sqlUpdate);
        
        $preparedStatement->bindValue(':name', $student->name());
        $preparedStatement->bindValue(':birth_date', $student->birthDate());
        $preparedStatement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $preparedStatement->execute();
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null){
            return $this->insert($student);
        }

        $this->update($student);
    }

    public function remove(Student $student): bool
    {
        $sqlDelete = 'DELETE FROM students WHERE id = :id;';
        $preparedStatement = $this->connection->prepare($sqlDelete);
        $preparedStatement->bindValue(':id', $student->id());
        return $preparedStatement->execute();
    }
}