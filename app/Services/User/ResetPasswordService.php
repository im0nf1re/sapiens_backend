<?php

namespace App\Services\User;

use App\Models\ResetPasswordCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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