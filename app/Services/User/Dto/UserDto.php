<?php

declare(strict_types=1);

namespace App\Services\User\Dto;

use App\ValueObjects\Email;
use App\ValueObjects\Ip;
use Carbon\Carbon;

final readonly class UserDto
{
    public function __construct(
        private int $id,
        private string $name,
        private Email $email,
        private Ip $ip,
        private string $comment,
        private Carbon $createdAt
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

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getIp(): Ip
    {
        return $this->ip;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
