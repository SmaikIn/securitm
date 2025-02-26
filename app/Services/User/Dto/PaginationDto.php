<?php

declare(strict_types=1);

namespace App\Services\User\Dto;


final readonly class PaginationDto
{
    public function __construct(
        private array $userDtos,
        private int $perPage,
        private int $total,
        private int $currentPage,
        private int $lastPage,
    ) {
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getUserDtos(): array
    {
        return $this->userDtos;
    }

}
