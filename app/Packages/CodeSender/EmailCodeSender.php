<?php 

namespace App\Packages\CodeSender;

use App\Mail\SendCode;
use App\Packages\CodeSender\Interfaces\CodeSender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailCodeSender implements CodeSender
{
    public function send(string $code, string $to): void
    {
        Mail::to($to)->send(new SendCode($code));
    }
}