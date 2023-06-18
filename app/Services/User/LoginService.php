<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function run(Request $request) {
        $user = $this->userRepository->findByPhone($request->phone);
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Введенные данные не верны.'],
            ]);
        }
     
        return $user->createToken($request->phone)->plainTextToken;
    }
}