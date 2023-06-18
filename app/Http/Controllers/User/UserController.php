<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckResetCodeRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\SendResetCodeRequest;
use App\Services\User\CreateService;
use App\Services\User\LoginService;
use App\Services\User\SendCodeService;

class UserController extends Controller
{
    public function login(LoginRequest $request, LoginService $loginService)
    {   
        $token = $loginService->run($request);
        return response($token);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request, CreateService $createService)
    {
        $token = $createService->run($request);
        return response($token);
    }

    public function sendResetCode(SendResetCodeRequest $request, SendCodeService $sendCodeService)  
    {
        $sendCodeService->run($request);

        return response('sended');
    }

    public function checkResetCode(CheckResetCodeRequest $request) 
    {
        
    }

    public function resetPassword(ResetPasswordRequest $request) 
    {

    }
}
