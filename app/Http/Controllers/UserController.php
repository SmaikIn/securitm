<?php

namespace App\Http\Controllers;

use app\Http\Requests\User\CreateUserRequest;
use app\Http\Requests\User\DeleteUserRequest;
use app\Http\Requests\User\IndexUserRequest;
use app\Http\Requests\User\ShowUserRequest;
use app\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Http\Responses\JsonApiResponse;
use App\Http\Responses\JsonErrorResponse;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use app\Services\User\Exceptions\ServiceException;
use App\Services\User\UserService;
use App\ValueObjects\Email;
use App\ValueObjects\Ip;
use App\ValueObjects\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(IndexUserRequest $request)
    {
        if (is_null($request->get('search'))) {
            return $this->getPagination($request);
        } else {
            return $this->getSearchPagination($request);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $dto = new CreateUserDto(
                name: $request->get('name'),
                email: Email::create($request->get('email')),
                password: Password::create($request->get('password')),
                ip: Ip::create($request->get('ip')),
                comment: $request->get('comment'),
            );
        } catch (\Throwable $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $bool = $this->userService->create($dto);
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($bool) {
            return new JsonApiResponse([], status: Response::HTTP_CREATED);
        } else {
            return new JsonApiResponse([], status: Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(ShowUserRequest $request)
    {
        $userId = $request->get('id');

        try {
            $user = $this->userService->find($userId);
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonApiResponse(UserResource::make($user)->toArray($request));
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $dto = new UpdateUserDto(
                id: $request->get('id'),
                name: $request->get('name'),
                password: Password::create($request->get('password')),
                ip: Ip::create($request->get('ip')),
                comment: $request->get('comment'),
            );
        } catch (\Throwable $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $bool = $this->userService->update($dto);
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($bool) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        } else {
            return new JsonApiResponse([], status: Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(DeleteUserRequest $request)
    {
        $userId = $request->get('id');

        try {
            $bool = $this->userService->delete($userId);
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($bool) {
            return new JsonApiResponse([], status: Response::HTTP_ACCEPTED);
        } else {
            return new JsonApiResponse([], status: Response::HTTP_BAD_REQUEST);
        }
    }


    private function getPagination(IndexUserRequest $request)
    {
        $page = $request->get('page', 1);
        try {
            $paginate = $this->userService->getUserPagination($page);
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return new JsonApiResponse(PaginateResource::make($paginate)->toArray($request));
    }

    private function getSearchPagination(IndexUserRequest $request)
    {
        try {
            $paginate = $this->userService->getSearchUserPagination($request->get('search'),
                $request->get('sort', false), $request->get('page', 1));
        } catch (ServiceException $exception) {
            return new JsonErrorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return new JsonApiResponse(PaginateResource::make($paginate)->toArray($request));
    }
}
