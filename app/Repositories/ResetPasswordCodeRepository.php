<?php

namespace App\Repositories;

use App\Models\ResetPasswordCode;
use App\Models\User;
use App\Repositories\Interfaces\ResetPasswordCodeRepositoryInterface;
use Carbon\Carbon;

class ResetPasswordCodeRepository implements ResetPasswordCodeRepositoryInterface
{
    public function findByUserAndCodeFor30Min(User $user, string $code): ?ResetPasswordCode
    {
        $resetPasswordCode = ResetPasswordCode::where('user_id', $user->id)
            ->where('created_at', '>', Carbon::now()->subMinutes(30))
            ->where('code', $code)
            ->first();

        return $resetPasswordCode;
    }

    public function findByUserFor1Min(User $user): ?ResetPasswordCode
    {
        $resetPasswordCode = ResetPasswordCode::where('user_id', $user->id)
            ->where('created_at', '>', Carbon::now()->subMinute())
            ->first();

        return $resetPasswordCode;
    }

    public function deleteOldCodesForUser(User $user): void
    {
        ResetPasswordCode::where('user_id', $user->id)->delete();
    }

    public function create($data): ResetPasswordCode
    {
        $resetPasswordCode = ResetPasswordCode::create($data);

        return $resetPasswordCode;
    }
}