<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function update(int $userId, array $data)
    {
        $user = User::findOrFail($userId);
        return $user->update($data);
    }

    public function find(int $id)
    {
        return User::findOrFail($id);
    }
}