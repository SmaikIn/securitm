<?php

declare(strict_types=1);

namespace App\Services\User\Dto;


use App\ValueObjects\Ip;
use App\ValueObjects\Password;

final readonly class UpdateUserDto
{
    public function __construct(
        private int $id,
        private string $name,
        private Password $password,
        private Ip $ip,
        private string $comment,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIp(): Ip
    {
        return $this->ip;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }


}
