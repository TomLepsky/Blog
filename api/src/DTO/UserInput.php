<?php

namespace App\DTO;

class UserInput
{
    public ?int $id;

    public string $login;

    public bool $isAdmin;

    public ?string $token;

    public array $permissions;
}
