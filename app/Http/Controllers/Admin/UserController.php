<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return UserResource::collection(
            $this->repository->getAllUsers( (array) $request->all() )
        );
    }

    public function store(UserRequest $request)
    {
        return new UserResource(
            $this->repository->createUser( (array) $request->validated() )
        );
    }

    public function show($id)
    {
        return new UserResource(
            $this->repository->getUserById($id)
        );
    }

    public function update(UserRequest $request, $id)
    {
        return $this->repository->updateUser(
            (array) $request->validated(), $id
        );
    }

    public function destroy($id)
    {
        return $this->repository->deleteUser($id);
    }
}
