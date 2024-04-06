<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TransactionResource;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\BaseTestCase;

class TransactionResourceTest extends BaseTestCase
{
    public function test_resource_transformation()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $subscription = Subscription::factory()->create(['name' => 'Example Subscription', 'user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'price' => 100
        ]);

        $resource = new TransactionResource($transaction);

        $expectedArray = [
            'id' => $transaction->id,
            'user_full_name' => 'John Doe',
            'subscription' => 'Example Subscription',
            'price' => 100
        ];

        $request = Request::create('/dummy-url', 'GET');
        $transformedArray = $resource->toArray($request);

        $this->assertEquals($expectedArray, $transformedArray);
    }
}
