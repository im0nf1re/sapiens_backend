<?php 

namespace App\Packages\CodeSender;

use App\Packages\CodeSender\Interfaces\CodeSender;
use App\Packages\ProstorSms\JsonGate;
use Illuminate\Support\Facades\Log;

class SmsCodeSender implements CodeSender 
{
    public function __construct(
        private JsonGate $gate
    ) {}

    public function send(string $code, string $to): void
    {
        Log::info($this->gate->credits());
    }
}