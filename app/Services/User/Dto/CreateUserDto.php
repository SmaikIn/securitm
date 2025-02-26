<?php

declare(strict_types=1);

namespace App\Services\User\Dto;


use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Ip;
use App\Domain\ValueObjects\Password;

final readonly class CreateUserDto
{
    public function __construct(
        private string $name,
        private Email $email,
        private Password $password,
        private Ip $ip,
        private string $comment,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
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
