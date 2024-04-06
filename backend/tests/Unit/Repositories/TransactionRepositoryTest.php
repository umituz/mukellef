<?php

namespace Tests\Unit\Repositories;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Tests\BaseTestCase;

class TransactionRepositoryTest extends BaseTestCase
{
    public function test_should_return_user_transactions_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transactions = Transaction::factory(3)->create(['user_id' => $user->id]);

        $repository = new TransactionRepository(new Transaction);
        $userTransactions = $repository->getUserTransactionList($user->id);

        $this->assertCount(3, $userTransactions);

        foreach ($transactions as $transaction) {
            $this->assertTrue($userTransactions->contains($transaction));
        }
    }

    public function test_should_create_a_new_user_transaction()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);
        $transactionData = [
            'price' => 100,
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ];

        $repository = new TransactionRepository(new Transaction);
        $createdTransaction = $repository->createUserTransaction($transactionData);

        $this->assertNotNull($createdTransaction->id);
        $this->assertEquals($user->id, $createdTransaction->user_id);
        $this->assertEquals($transactionData['price'], $createdTransaction->price);
    }
}
