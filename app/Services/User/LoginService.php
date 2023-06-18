<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function run(Request $request) {
        $user = User::where('phone', $request->phone)->first();
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Введенные данные не верны.'],
            ]);
        }
     
        return $user->createToken($request->phone)->plainTextToken;
    }
}