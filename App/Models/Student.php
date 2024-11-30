<?php

namespace App\Models;

use App\Core\Model;

class Student extends Model
{
    protected ?int $id = null;
    protected ?string $jazyk;

    protected ?string $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getJazyk(): ?string
    {
        return $this->jazyk;
    }

    public function setJazyk(?string $jazyk): void
    {
        $this->jazyk = $jazyk;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

}