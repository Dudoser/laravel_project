<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByLogin(string $username, string $phoneNumber): ?User
    {
        return User::where('username', $username)
            ->where('phone_number', $phoneNumber)
            ->first();
    }
}
