<?php

namespace App\Services\User;

use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\PaginationDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use app\Services\User\Exceptions\ServiceException;
use App\Services\User\Repositories\CacheUserRepository;
use App\Services\User\Repositories\DatabaseUserRepository;
use Illuminate\Support\Facades\Log;

final readonly class UserService
{
    public function __construct(
        private DatabaseUserRepository $databaseUserRepository,
        private CacheUserRepository $cacheUserRepository,
    ) {
    }

    private const ITEMS_ON_PAGE = 16;


    public function getSearchUserPagination(string $search, bool $sortFlag, int $page): PaginationDto
    {
        try {
            $paginateDto = $this->databaseUserRepository->getSearchPage($search, $sortFlag, $page, self::ITEMS_ON_PAGE);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }

        return $paginateDto;
    }

    public function getUserPagination(int $page): PaginationDto
    {
        if ($page === 1) {
            try {
                $paginateDto = $this->cacheUserRepository->getFirstPage();
                if ($paginateDto instanceof PaginationDto) {
                    return $paginateDto;
                }
            } catch (\Throwable $exception) {
                Log::channel('stderr')->debug('UserService:',
                    [
                        'message' => $exception->getMessage(),
                    ]
                );
            }
        }
        try {
            $paginateDto = $this->databaseUserRepository->getPage($page, self::ITEMS_ON_PAGE);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }

        if ($page === 1) {
            try {
                $this->cacheUserRepository->setFirstPage($paginateDto);
            } catch (\Throwable $exception) {
                Log::channel('stderr')->debug('UserService:',
                    [
                        'message' => $exception->getMessage(),
                    ]
                );
            }
        }

        return $paginateDto;
    }

    public function find(int $userId): UserDto
    {
        try {
            $user = $this->cacheUserRepository->find($userId);
            if ($user instanceof UserDto) {
                return $user;
            }
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
        }

        try {
            $user = $this->databaseUserRepository->find($userId);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }

        try {
            $this->cacheUserRepository->setUser($user);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
        }

        return $user;
    }


    public function delete(int $userId): bool
    {
        try {
            return $this->databaseUserRepository->delete($userId);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    public function create(CreateUserDto $createUserDto): bool
    {
        try {
            return $this->databaseUserRepository->create($createUserDto);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(UpdateUserDto $updateUserDto): bool
    {
        try {
            return $this->databaseUserRepository->update($updateUserDto);
        } catch (\Throwable $exception) {
            Log::channel('stderr')->debug('UserService:',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }
    }

}
