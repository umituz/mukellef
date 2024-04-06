<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\BaseTestCase;

class UserDetailResourceTest extends BaseTestCase
{
    public function test_should_return_user_detail_resource_correctly()
    {
        $user = User::factory()->create();
        $subscriptions = [];
        $transactions = [];

        $resource = new UserDetailResource($user);
        $toArray = $resource->toArray(new Request);

        $expectedArray = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'subscriptions' => $subscriptions,
            'transactions' => $transactions,
        ];

        $this->assertEquals($expectedArray, $toArray);
    }
}
