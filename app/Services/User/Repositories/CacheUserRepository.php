<?php

namespace App\Services\User\Repositories;

use App\Services\User\Dto\PaginationDto;
use App\Services\User\Dto\UserDto;
use Illuminate\Support\Facades\Cache;


final class CacheUserRepository
{

    public function getFirstPage()
    {
        return Cache::get(config('cache.keys.users.first-page'));
    }

    /**
     * @param  PaginationDto  $createUserDto
     * @return void
     */
    public function setFirstPage(PaginationDto $createUserDto): void
    {
        Cache::set(config('cache.keys.users.first_page'), $createUserDto);
    }

    public function find(int $userId)
    {
        $key = sprintf(config('cache.keys.users.user'), $userId);

        return Cache::get($key);
    }

    public function setUser(UserDto $userDto): void
    {
        $key = sprintf(config('cache.keys.users.user'), $userDto->getId());

        Cache::set($key, $userDto);
    }
}
