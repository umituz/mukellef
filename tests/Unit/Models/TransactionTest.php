<?php

namespace Tests\Unit\Models;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Tests\BaseTestCase;

class TransactionTest extends BaseTestCase
{
    public function test_user_relation()
    {
        $user = User::factory()->create();

        $subscription = Subscription::factory()->create();

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ]);

        $this->assertInstanceOf(User::class, $transaction->user);
        $this->assertEquals($user->id, $transaction->user->id);
    }

    public function test_subscription_relation()
    {
        $user = User::factory()->create();

        $subscription = Subscription::factory()->create();

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ]);

        $this->assertInstanceOf(Subscription::class, $transaction->subscription);
        $this->assertEquals($subscription->id, $transaction->subscription->id);
    }
}
