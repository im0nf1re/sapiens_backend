<?php

namespace App\Repositories\Interfaces;

use App\Models\ResetPasswordCode;
use App\Models\User;

interface ResetPasswordCodeRepositoryInterface
{
    public function findByUserAndCodeFor30Min(User $user, string $code): ?ResetPasswordCode;

    public function findByUserFor1Min(User $user): ?ResetPasswordCode;

    public function deleteOldCodesForUser(User $user): void;

    public function create(array $data): ResetPasswordCode;
}