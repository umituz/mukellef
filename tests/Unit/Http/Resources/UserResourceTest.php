<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\BaseTestCase;

class UserResourceTest extends BaseTestCase
{
    public function test_resource_transformation()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'password' => bcrypt(123456789),
            'email' => 'john@example.com',
        ]);

        $resource = new UserResource($user);

        $expectedArray = [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ];

        $request = Request::create('/dummy-url', 'GET');
        $transformedArray = $resource->toArray($request);

        $this->assertEquals($expectedArray, $transformedArray);
    }
}
