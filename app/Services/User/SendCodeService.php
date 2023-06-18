<?php

namespace App\Services\User;

use App\Packages\CodeSender\Interfaces\CodeSender;
use Illuminate\Http\Request;

class SendCodeService
{
    public function __construct(
        private CodeSender $codeSender
    ) {}

    public function run(Request $request) {
        $code = $this->generateCode();
        $this->codeSender->send($code, $request->to);
    }

    private function generateCode(): string
    {
        $code = sprintf("%04d", mt_rand(0, 9999));
        return $code;
    }
}