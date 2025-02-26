<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\User\Dto\UserDto;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        /**
         * @var UserDto $user
         */
        $user = $this;

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail()->value(),
            'ip' => $user->getIp()->value(),
            'comment' => $user->getComment(),
            'created_at' => $user->getCreatedAt()->toString(),
        ];
    }
}
