<?php

namespace App\Packages\CodeSender\Interfaces;

interface CodeSender
{
    public function send(string $code, string $to): void;
}