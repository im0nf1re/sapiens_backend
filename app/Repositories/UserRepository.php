<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByTypeAndTo(string $type, string $to): ?User
    {
        $user = User::where($type, $to)->first();

        return $user;
    }

    public function findByPhone(string $phone): ?User
    {
        $user = User::where('phone', $phone)->first();

        return $user;
    }

    public function create(array $data): User
    {
        $user = User::create($data);

        return $user;
    }
}