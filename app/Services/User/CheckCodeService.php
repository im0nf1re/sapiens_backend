<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use App\Models\ResetPasswordToken;
use App\Models\User;
use App\Packages\CodeSender\Interfaces\CodeSender;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckCodeService
{
    public function run(Request $request): ResetPasswordCode {
        $user = $this->getUser($request->to, $request->type);

        $resetPasswordCode = $this->getResetPasswordCode($user, $request->code);

        return $resetPasswordCode;
    }

    private function getUser($to, $type): User
    {
        $user = User::where($type, $to)->first();
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }

    private function getResetPasswordCode(User $user, string $code): ResetPasswordCode
    {
        $resetPasswordCode = ResetPasswordCode::where('user_id', $user->id)
            ->where('created_at', '>', Carbon::now()->subMinutes(30))
            ->where('code', $code)
            ->first();

        if (!$resetPasswordCode) {
            throw new Exception('Code is not match!');
        }

        return $resetPasswordCode;
    }
}