<?php

namespace App\Http\Resources;

use App\Services\User\Dto\PaginationDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /**
         * @var PaginationDto $this
         */
        $paginate = $this;

        return [
            'users' => UserResource::collection($paginate->getUserDtos())->toArray($request),
            'pagination' => [
                'total' => $paginate->getTotal(),
                'currentPage' => $paginate->getCurrentPage(),
                'lastPage' => $paginate->getLastPage(),
                'perPage' => $paginate->getPerPage(),
            ],

        ];
    }
}
