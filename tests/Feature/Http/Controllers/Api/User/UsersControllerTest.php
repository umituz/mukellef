<?php

namespace Tests\Feature\Http\Controllers\Api\User;

use App\Models\User;
use Tests\BaseTestCase;

class UsersControllerTest extends BaseTestCase
{
    public function test_should_return_user_details()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $subscription = $user->subscriptions()->create(['user_id' => $user, 'name' => 'Subscription 1', 'renewal_at' => now()]);
        $user->transactions()->create(['user_id' => $user, 'subscription_id' => $subscription->id,  'price' => 100]);

        $response = $this->getJson(route('users.index', $user));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'subscriptions',
                    'transactions',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'subscriptions' => [
                        ['name' => 'Subscription 1'],
                    ],
                    'transactions' => [
                        ['price' => 100],
                    ],
                ],
            ]);
    }
}
