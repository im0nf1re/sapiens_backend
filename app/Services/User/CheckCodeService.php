<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use App\Repositories\Interfaces\ResetPasswordCodeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CheckCodeService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ResetPasswordCodeRepositoryInterface $resetPasswordCodeRepository
    ) {}

    public function run(Request $request): ResetPasswordCode {
        $user = $this->userRepository->findByTypeAndTo($request->type, $request->to);
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        $resetPasswordCode = $this->resetPasswordCodeRepository->findByUserAndCodeFor30Min($user, $request->code);
        if (!$resetPasswordCode) {
            throw new Exception('Code is not match!');
        }

        return $resetPasswordCode;
    }
}