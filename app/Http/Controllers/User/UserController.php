<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckResetCodeRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\SendResetCodeRequest;
use App\Services\User\CheckCodeService;
use App\Services\User\CreateService;
use App\Services\User\LoginService;
use App\Services\User\ResetPasswordService;
use App\Services\User\SendCodeService;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function login(LoginRequest $request, LoginService $loginService)
    {   
        DB::beginTransaction();
        try {

            $token = $loginService->run($request);

            DB::commit();
            return response($token);

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request, CreateService $createService)
    {
        DB::beginTransaction();
        try {

            $token = $createService->run($request);
        
            DB::commit();
            return response($token);

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }

    public function sendResetCode(SendResetCodeRequest $request, SendCodeService $sendCodeService)  
    {
        DB::beginTransaction();
        try {

            $sendCodeService->run($request);

            DB::commit();
            return response('sended');

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }

    public function checkResetCode(CheckResetCodeRequest $request, CheckCodeService $checkCodeService) 
    {
        DB::beginTransaction();
        try {

            $checkCodeService->run($request);
        
            DB::commit();
            return response('ok');

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }

    public function resetPassword(ResetPasswordRequest $request, CheckCodeService $checkCodeService, ResetPasswordService $resetPasswordService) 
    {
        DB::beginTransaction();
        try {

            $resetPasswordCode = $checkCodeService->run($request);
            $resetPasswordService->run($request, $resetPasswordCode);
        
            DB::commit();
            return response('ok');

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }
}
