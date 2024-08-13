<?php

namespace Alura\Pdo\Domain\Model;

use DomainException;
use Phone;

class Student
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;
    private array $phones = [];

    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function addPhone(Phone $newPhone)
    {
        $this->phones = $newPhone;
    }

    public function getPhones(): array
    {
        return $this->phones;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function changeName(string $name)
    {
        $this->name = $name;
    }

    public function defineId(int $id)
    {
        if(is_null($id)){
            throw new DomainException('O ID só pode ser definido uma vez!');
        }

        $this->id = $id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }
}
