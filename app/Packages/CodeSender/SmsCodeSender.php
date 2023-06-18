<?php 

namespace App\Packages\CodeSender;

use App\Packages\CodeSender\Interfaces\CodeSender;
use App\Packages\ProstorSms\JsonGate;
use Exception;
use Illuminate\Support\Facades\Log;

class SmsCodeSender implements CodeSender 
{
    public function __construct(
        private JsonGate $gate
    ) {}

    public function send(string $code, string $to): void
    {
        $message = [
            'phone' => $to,
            'text' => 'Ваш код восстановления: ' . $code,
        ];

        $response = $this->gate->send([$message]);

        if ($response['status'] != 'ok') {
            throw new Exception($response['messages'][0]);
        }
    }
}