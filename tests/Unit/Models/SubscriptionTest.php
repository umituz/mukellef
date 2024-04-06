<?php

namespace Tests\Unit\Models;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;

class SubscriptionTest extends BaseTestCase
{
    use RefreshDatabase;

    public function test_user_relation()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $subscription->user);
        $this->assertEquals($user->id, $subscription->user->id);
    }

    public function test_transaction_relation()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'price' => 100
        ]);

        $this->assertInstanceOf(Transaction::class, $subscription->transaction);
        $this->assertEquals($transaction->id, $subscription->transaction->id);
    }
}
