<?php

namespace App\Adapters;

interface PaymentGateway
{
    public function pay(float $amount): bool;
}
