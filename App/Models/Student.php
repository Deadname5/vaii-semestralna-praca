<?php

namespace App\Models;

use App\Core\Model;
use DateTime;

class Student extends Model
{
    protected ?int $id = null;
    protected ?string $jazyk;

    protected ?string $zaciatok;

    protected ?string $koniec;

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

    public function getZaciatok(): ?string
    {
        return $this->zaciatok;
    }

    public function setZaciatok(?string $zaciatok): void
    {
        $this->zaciatok = $zaciatok;
    }

    public function getKoniec(): ?string
    {
        return $this->koniec;
    }

    public function setKoniec(?string $koniec): void
    {
        $this->koniec = $koniec;
    }

}