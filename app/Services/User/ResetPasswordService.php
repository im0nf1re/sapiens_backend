<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    public function run(Request $request, ResetPasswordCode $resetPasswordCode) {
        $user = $resetPasswordCode->user;

        $user->password = Hash::make($request->password);
        $user->tokens()->delete();
        $resetPasswordCode->delete();

        $user->save();
    }
}