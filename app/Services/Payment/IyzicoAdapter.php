<?php

namespace App\Services\Payment;

class IyzicoAdapter implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        return true;
    }
}
