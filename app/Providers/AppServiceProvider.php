<?php

namespace App\Providers;

use App\Http\Controllers\User\UserController;
use App\Packages\CodeSender\EmailCodeSender;
use App\Packages\CodeSender\Interfaces\CodeSender;
use App\Packages\CodeSender\SmsCodeSender;
use App\Packages\ProstorSms\JsonGate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CodeSender::class, function ($app) {
            return request()->type === 'phone'
                ? $app->make(SmsCodeSender::class)
                : $app->make(EmailCodeSender::class);
        });

        $this->app->singleton(JsonGate::class, function ($app) {
            return new JsonGate(env('SMS_LOGIN'), env('SMS_PASSWORD'));
        });
    }
}
