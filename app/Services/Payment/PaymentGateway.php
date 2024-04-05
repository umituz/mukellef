<?php

namespace App\Services\Payment;

interface PaymentGateway
{
    public function pay(float $amount): bool;
}
