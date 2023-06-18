<?php

namespace App\Services\User;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function run(Request $request) {
        $user = $this->userRepository->findByPhone($request->phone);

        if ($user) {
            throw ValidationException::withMessages([
                'phone' => ['User already exists'],
            ]);
        }

        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password
        ]);

        return $user->createToken($request->phone)->plainTextToken;
    }
}