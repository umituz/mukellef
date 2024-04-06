<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\BaseTestCase;

class SubscriptionResourceTest extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Test resource transformation.
     *
     * @return void
     */
    public function test_resource_transformation()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $subscription = Subscription::factory()->create([
            'name' => 'Example Subscription',
            'user_id' => $user->id,
            'renewal_at' => now(),
        ]);

        $resource = new SubscriptionResource($subscription);

        $expectedArray = [
            'id' => $subscription->id,
            'name' => 'Example Subscription',
            'user_full_name' => 'John Doe',
            'renewal_at' => now(),
        ];

        $request = Request::create('/dummy-url', 'GET');
        $transformedArray = $resource->toArray($request);

        $this->assertEquals($expectedArray, $transformedArray);
    }
}
