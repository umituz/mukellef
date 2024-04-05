<?php

namespace App\Services\Payment;

class StripeAdapter implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        return true;
    }
}
