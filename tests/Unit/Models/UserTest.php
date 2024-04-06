<?php

namespace Tests\Unit\Models;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Tests\BaseTestCase;

class UserTest extends BaseTestCase
{

    public function test_subscriptions_relation()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Subscription::class, $user->subscriptions->first());
        $this->assertEquals($subscription->id, $user->subscriptions->first()->id);
    }

    public function test_transactions_relation()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create(['user_id' => $user->id, 'subscription_id' => $subscription->id]);

        $this->assertInstanceOf(Transaction::class, $user->transactions->first());
        $this->assertEquals($transaction->id, $user->transactions->first()->id);
    }
}
