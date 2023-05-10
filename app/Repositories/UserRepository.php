<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $entity;

    public function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function getAllUsers(array $filters = [])
    {
        return  $this->entity->where(function ($query) use ($filters) {

            if (isset($filters['name'])) {
                $query->where('name', 'LIKE', "%{$filters['name']}%");
            }

            if (isset($filters['active'])) {
                $query->whereActive($filters['active']);
            } else {
                $query->whereActive(true);
            }
                
        })->paginate();
    }

    public function getUserById(string $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function createUser(array $users)
    {
        $users['password'] = bcrypt($users['password']);

        return $this->entity->create($users);
    }

    public function updateUser(array $users, string $id)
    {
        $user = $this->entity->findOrFail($id);

        if ( isset($users['password']) ) {
            $users['password'] = bcrypt($users['password']);
        }

        $user->update($users);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function deleteUser(string $id)
    {
        $user = $this->entity->findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
