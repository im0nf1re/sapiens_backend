<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use Illuminate\Http\Request;

class ResetPasswordService
{
    public function run(Request $request, ResetPasswordCode $resetPasswordCode) {
        $resetPasswordCode->user->updateWithNewPassword($request->password);
        $resetPasswordCode->delete();
    }
}