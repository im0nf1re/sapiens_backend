<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckResetCodeRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\SendResetCodeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {   
        $user = User::where('phone', $request->phone)->first();
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Введенные данные не верны.'],
            ]);
        }
     
        return $user->createToken($request->phone)->plainTextToken;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request)
    {
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

    public function sendResetCode(SendResetCodeRequest $request) 
    {
        
    }

    public function checkResetCode(CheckResetCodeRequest $request) 
    {
        
    }

    public function resetPassword(ResetPasswordRequest $request) 
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
