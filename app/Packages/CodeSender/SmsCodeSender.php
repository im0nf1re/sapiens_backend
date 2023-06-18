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
            'sender' => 'Sapiens'
        ];

        $response = $this->gate->send([$message]);
        
        if ($response['status'] != 'ok') {
            throw new Exception("Can't connect to SMS gate!");
        }
        if (isset($response['messages'][0]['status']) && $response['messages'][0]['status'] !== 'accepted') {
            throw new Exception($response['messages'][0]['status']);
        }
    }
}