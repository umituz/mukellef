<?php

namespace App\Adapters;

class StripeAdapter implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        return true;
    }
}
