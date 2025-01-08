<?php

namespace App\Models;

use App\Core\Model;

class Schedule extends Model
{
    protected ?int $id = null;
    protected ?int $teacher_id = null;

    protected ?int $student_id = null;

    protected ?string $language;

    protected ?string $start;

    protected ?string $end;

    public function getTeacherId(): ?int
    {
        return $this->teacher_id;
    }

    public function setTeacherId(?int $teacher_id): void
    {
        $this->teacher_id = $teacher_id;
    }

    public function getStudentId(): ?int
    {
        return $this->student_id;
    }

    public function setStudentId(?int $student_id): void
    {
        $this->student_id = $student_id;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(?string $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(?string $end): void
    {
        $this->end = $end;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

}