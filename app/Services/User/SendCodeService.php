<?php

namespace App\Services\User;

use App\Packages\CodeSender\Interfaces\CodeSender;
use App\Repositories\Interfaces\ResetPasswordCodeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SendCodeService
{
    public function __construct(
        private CodeSender $codeSender,
        private UserRepositoryInterface $userRepository,
        private ResetPasswordCodeRepositoryInterface $resetPasswordCodeRepository
    ) {}

    public function run(Request $request) {
        $user = $this->userRepository->findByTypeAndTo($request->type, $request->to);
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        if (!$this->resetPasswordCodeRepository->findByUserFor1Min($user)) {
            throw new Exception("To send code again you should wait at least a minute!");
        }

        $this->resetPasswordCodeRepository->deleteOldCodesForUser($user);
        $code = $this->generateCode();
        $this->resetPasswordCodeRepository->create([
            'user_id' => $user->id,
            'code' => $code
        ]);
        
        $this->codeSender->send($code, $request->to);
    }

    private function generateCode(): string
    {
        $code = sprintf("%04d", mt_rand(0, 9999));
        return $code;
    }
}