<?php

namespace App\Services\Base;

use App\Adapters\IyzicoAdapter;
use App\Adapters\PaymentGateway;
use App\Adapters\StripeAdapter;
use App\Models\User;

class PaymentService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pay(int $userId, float $amount): bool
    {
        $user = $this->userService->find($userId);
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
