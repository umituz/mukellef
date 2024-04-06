<?php

namespace Tests\Feature\Http\Controllers\Api\Subscription;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\BaseTestCase;

class SubscriptionsControllerTest extends BaseTestCase
{
    public function test_should_return_all_user_subscription_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Subscription::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('users.subscriptions.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'renewal_at',
                ],
            ],
        ]);
    }

    public function test_should_store_a_new_user_subscription_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $subscriptionData = Subscription::factory()->make([
            'renewal_at' => '2024/05/06',
            'user_id' => $user->id
        ])->toArray();

        $response = $this->postJson(route('users.subscriptions.store'), $subscriptionData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('subscriptions', $subscriptionData);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'renewal_at',
            ],
        ]);
    }

    public function test_should_return_error_when_storing_subscription_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [];
        $response = $this->postJson(route('users.subscriptions.store'), $invalidData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name', 'renewal_at']);
    }

    public function test_should_update_user_subscription_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = Subscription::factory()->create(['user_id' => $user->id]);
        $newData = Subscription::factory()->make([
            'renewal_at' => '2024/05/01',
            'user_id' => $user->id
        ])->toArray();

        $response = $this->putJson(route('users.subscriptions.update', $subscription->id), $newData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'renewal_at',
            ],
        ]);
        $this->assertDatabaseHas('subscriptions', $newData);
    }

    public function test_should_return_error_when_updating_user_subscription_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = Subscription::factory()->create(['user_id' => $user->id]);
        $invalidData = [];
        $response = $this->putJson(route('users.subscriptions.update', $subscription->id), $invalidData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name', 'renewal_at']);
    }

    public function test_should_return_error_when_trying_to_update_non_existing_subscription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $nonExistingSubscriptionId = 9999;
        $response = $this->putJson(route('users.subscriptions.update', $nonExistingSubscriptionId), []);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_should_destroy_user_subscription_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('users.subscriptions.destroy', $subscription->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted('subscriptions', ['id' => $subscription->id]);
    }

    public function test_should_return_error_when_trying_to_delete_non_existing_subscription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $nonExistingSubscriptionId = 9999;
        $response = $this->deleteJson(route('users.subscriptions.destroy', $nonExistingSubscriptionId));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
