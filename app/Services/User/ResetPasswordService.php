<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class ResetPasswordService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function run(Request $request, ResetPasswordCode $resetPasswordCode) {
        $user = $resetPasswordCode->user;
        $this->userRepository->updateWithNewPassword($user, $request->password);
        $resetPasswordCode->delete();
    }
}