<?php

namespace App\Services\User\Repositories;

use App\Models\User;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\PaginationDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use App\ValueObjects\Email;
use App\ValueObjects\Ip;


final class DatabaseUserRepository
{

    /**
     * @param  int  $page
     * @param  int  $perPage
     * @return PaginationDto;
     */
    public function getPage(int $page, int $perPage): PaginationDto
    {
        $dbUsers = User::paginate(perPage: $perPage, page: $page);

        $users = [];
        foreach ($dbUsers->getCollection() as $dbUser) {
            $users[] = $this->formatUserDto($dbUser);
        }

        return new PaginationDto(
            userDtos: $users,
            perPage: $dbUsers->perPage(),
            total: $dbUsers->total(),
            currentPage: $dbUsers->currentPage(),
            lastPage: $dbUsers->lastPage(),
        );
    }

    public function getSearchPage(string $search, bool $sortFlag, int $page, int $perPage): PaginationDto
    {
        $dbUsersQuery = User::where('name', 'like', '%'.$search.'%');

        if ($sortFlag) {
            $dbUsersQuery = $dbUsersQuery->orderBy('name');
        }

        $dbUsers = $dbUsersQuery->paginate(perPage: $perPage, page: $page);

        $users = [];
        foreach ($dbUsers as $dbUser) {
            $users[] = $this->formatUserDto($dbUser);
        }

        return new PaginationDto(
            userDtos: $users,
            perPage: $dbUsers->perPage(),
            total: $dbUsers->total(),
            currentPage: $dbUsers->currentPage(),
            lastPage: $dbUsers->lastPage(),
        );
    }

    public function find(int $userId): UserDto
    {
        $user = User::findOrFail($userId);

        return $this->formatUserDto($user);
    }

    public function create(CreateUserDto $createUserDto): bool
    {
        $user = new User;
        $user->password = \Hash::make($createUserDto->getPassword()->value());
        $user->email = $createUserDto->getEmail()->value();
        $user->name = $createUserDto->getName();
        $user->ip = $createUserDto->getIp()->value();
        $user->comment = $createUserDto->getComment();

        return $user->save();
    }

    public function update(UpdateUserDto $updateUserDto): bool
    {
        $user = User::findOrFail($updateUserDto->getId());

        $user->password = \Hash::make($updateUserDto->getPassword()->value());
        $user->name = $updateUserDto->getName();
        $user->ip = $updateUserDto->getIp()->value();
        $user->comment = $updateUserDto->getComment();

        return $user->save();
    }

    public function delete(int $userId): bool
    {
        $user = User::findOrFail($userId);

        return $user->delete();
    }

    private function formatUserDto(User $user): UserDto
    {
        return new UserDto(
            id: $user->id,
            name: $user->name,
            email: Email::create($user->email),
            ip: Ip::create($user->ip),
            comment: $user->comment,
            createdAt: $user->created_at,
        );
    }
}
