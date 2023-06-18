<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use App\Models\User;
use App\Packages\CodeSender\Interfaces\CodeSender;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SendCodeService
{
    public function __construct(
        private CodeSender $codeSender
    ) {}

    public function run(Request $request) {
        $user = $this->getUser($request->to, $request->type);

        // if (!$this->isMinuteInterval($user)) {
        //     throw new Exception("To send code again you should wait at least a minute!");
        // }

        $this->clearOldCodesForUser($user);
        $code = $this->generateCode();
        $this->saveCode($code, $user);
        
        $this->codeSender->send($code, $request->to);
    }

    private function generateCode(): string
    {
        $code = sprintf("%04d", mt_rand(0, 9999));
        return $code;
    }

    private function getUser($to, $type): User
    {
        $user = User::where($type, $to)->first();
        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }

    private function isMinuteInterval(User $user) {
        $resetPasswordCode = ResetPasswordCode::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subMinute())->first();

        if ($resetPasswordCode) {
            return false;
        } else {
            return true;
        }
    }

    private function saveCode(string $code, User $user): void
    {
        $resetPasswordCode = new ResetPasswordCode();
        $resetPasswordCode->user_id = $user->id;
        $resetPasswordCode->code = $code;
        $resetPasswordCode->save();
    }

    private function clearOldCodesForUser(User $user): void
    {
        ResetPasswordCode::where('user_id', $user->id)->delete();
    }
}