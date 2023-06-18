<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateService
{
    public function run(Request $request) {
        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            throw ValidationException::withMessages([
                'phone' => ['Пользователь уже существует'],
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user->createToken($request->phone)->plainTextToken;
    }
}