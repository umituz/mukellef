<?php

namespace Tests\Unit\Repositories;

use App\Models\Subscription;
use App\Models\User;
use App\Repositories\SubscriptionRepository;
use Tests\BaseTestCase;

class SubscriptionRepositoryTest extends BaseTestCase
{
    public function test_should_return_user_subscriptions_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscriptions = Subscription::factory(3)->create(['user_id' => $user->id]);

        $repository = new SubscriptionRepository(new Subscription);
        $userSubscriptions = $repository->getUserSubscriptionList($user->id);

        $this->assertCount(3, $userSubscriptions);
        foreach ($subscriptions as $subscription) {
            $this->assertTrue($userSubscriptions->contains($subscription));
        }
    }

    public function test_should_create_a_new_user_subscription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $subscriptionData = ['user_id' => $user->id, 'name' => 'Test Subscription', 'renewal_at' => now()];

        $repository = new SubscriptionRepository(new Subscription);
        $createdSubscription = $repository->createUserSubscription($subscriptionData);

        $this->assertInstanceOf(Subscription::class, $createdSubscription);
        $this->assertEquals($user->id, $createdSubscription->user_id);
        $this->assertEquals('Test Subscription', $createdSubscription->name);
    }

    public function test_should_return_renewable_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Subscription::factory()->create(['user_id' => $user->id, 'renewal_at' => now()->subDay()]);
        Subscription::factory()->create(['user_id' => $user->id, 'renewal_at' => now()->addDay()]);

        $repository = new SubscriptionRepository(new Subscription);
        $renewableItems = $repository->getRenewableItems();

        $this->assertCount(1, $renewableItems);
    }

}
