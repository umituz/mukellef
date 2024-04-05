<?php

namespace App\Adapters;

class IyzicoAdapter implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        return true;
    }
}
