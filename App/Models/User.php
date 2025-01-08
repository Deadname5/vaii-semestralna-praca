<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected ?int $id = null;
    protected ?string $login;
    protected ?string $password;

    protected ?int $roles_id = null;

    protected ?int $teacher_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRolesId(): ?int
    {
        return $this->roles_id;
    }

    public function setRolesId(?int $roles_id): void
    {
        $this->roles_id = $roles_id;
    }

    public function getTeacherId(): ?int
    {
        return $this->teacher_id;
    }

    public function setTeacherId(?int $teacher_id): void
    {
        $this->teacher_id = $teacher_id;
    }

}