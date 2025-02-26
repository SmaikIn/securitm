<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;


class UserObserver
{
    public function created(User $user): void
    {
        Cache::forget(config('cache.keys.users.first-page'));
    }

    public function updated(User $user): void
    {
        Cache::forget(config('cache.keys.users.first-page'));

        $key = sprintf(config('cache.keys.users.user'), $user->id);
        Cache::forget($key);
    }

    public function deleted(User $user): void
    {
        Cache::forget(config('cache.keys.users.first-page'));

        $key = sprintf(config('cache.keys.users.user'), $user->id);
        Cache::forget($key);
    }
}
