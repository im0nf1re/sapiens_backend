<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByTypeAndTo(string $type, string $to): ?User;

    public function findByPhone(string $phone): ?User;

    public function create(array $data): User;
}