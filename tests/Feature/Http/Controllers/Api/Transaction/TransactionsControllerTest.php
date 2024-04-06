<?php

namespace Tests\Feature\Http\Controllers\Api\Transaction;

use App\Http\Resources\TransactionResource;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\Base\PaymentService;
use App\Services\Base\TransactionService;
use App\Services\Mail\MailService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\BaseTestCase;

class TransactionsControllerTest extends BaseTestCase
{
    public function test_should_return_all_user_transactions()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);
        $transactions = Transaction::factory(3)->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ]);
        $transactions = TransactionResource::collection($transactions);

        $transactionServiceMock = $this->mock(TransactionService::class);
        $transactionServiceMock->shouldReceive('getTransactionList')->andReturn(collect($transactions));
        $response = $this->actingAs($user)->get(route('users.transactions.index', $user->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_full_name',
                    'subscription',
                ],
            ],
        ]);
    }

    public function test_should_store_transaction_successfully()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->andReturn($user);

        $transactionRepositoryMock = $this->mock(TransactionRepositoryInterface::class);
        $transactionRepositoryMock->shouldReceive('createUserTransaction')->andReturn(true);

        $paymentServiceMock = $this->mock(PaymentService::class);
        $paymentServiceMock->shouldReceive('pay')->andReturn(true);

        $mailServiceMock = $this->mock(MailService::class);
        $mailServiceMock->shouldReceive('sendMailByEvent');

        $transactionService = new TransactionService(
            $transactionRepositoryMock,
            $mailServiceMock,
            $paymentServiceMock
        );

        $data = [
            'user_id' => $user->id,
            'subscription_id' => 1,
            'price' => 100,
        ];

        $response = $transactionService->createTransaction($data);

        $this->assertInstanceOf(TransactionResource::class, $response);
        $this->assertTrue($response->resource);
        $this->assertEmpty($response->additional);
    }

    public function test_should_not_store_user_transaction()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->andReturn($user);

        $transactionRepositoryMock = $this->mock(TransactionRepositoryInterface::class);
        $transactionRepositoryMock->shouldReceive('createUserTransaction')->never();

        $paymentServiceMock = $this->mock(PaymentService::class);
        $paymentServiceMock->shouldReceive('pay')->andReturn(false);

        $mailServiceMock = $this->mock(MailService::class);
        $mailServiceMock->shouldReceive('sendMailByEvent')->never();

        $transactionService = new TransactionService(
            $transactionRepositoryMock,
            $mailServiceMock,
            $paymentServiceMock
        );

        $data = [
            'user_id' => $user->id,
            'subscription_id' => 1,
            'price' => 100,
        ];

        $response = $transactionService->createTransaction($data);

        $this->assertNull($response);
    }
}
