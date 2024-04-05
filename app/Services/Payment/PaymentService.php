<?php

namespace App\Services\Payment;

use App\Models\User;

class PaymentService
{
    public function pay(User $user, float $amount): bool
    {
        $gateway = $this->getPaymentGateway($user);

        if ($gateway) {
            return $gateway->pay($amount);
        }

        return false;
    }

    private function getPaymentGateway(User $user): ?PaymentGateway
    {
        return match ($user->payment_provider) {
            'stripe' => new StripeAdapter(),
            'iyzico' => new IyzicoAdapter(),
            default => null,
        };
    }
}
