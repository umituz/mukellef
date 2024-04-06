<?php

namespace Tests\Unit\Http\Requests\Subscription;

use App\Http\Requests\Subscription\SubscriptionRequest;
use Illuminate\Support\Facades\Validator;
use Tests\BaseTestCase;

class SubscriptionRequestTest extends BaseTestCase
{
    public function test_authorize_method()
    {
        $request = new SubscriptionRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_rules_method()
    {
        $request = new SubscriptionRequest();

        $rules = $request->rules();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('renewal_at', $rules);
    }

    public function test_validation_passes()
    {
        $data = [
            'name' => 'Example Subscription',
            'renewal_at' => '2024-05-01',
        ];

        $request = new SubscriptionRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_validation_fails()
    {
        $data = [
            'name' => '',
            'renewal_at' => 'invalid_date',
        ];

        $request = new SubscriptionRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());

        $errors = $validator->errors()->messages();

        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('renewal_at', $errors);
    }

    public function test_messages_method()
    {
        $request = new SubscriptionRequest();

        $messages = $request->messages();

        $this->assertIsArray($messages);
        $this->assertArrayHasKey('name.required', $messages);
        $this->assertArrayHasKey('name.string', $messages);
        $this->assertArrayHasKey('renewal_at.required', $messages);
        $this->assertArrayHasKey('renewal_at.date', $messages);
    }

    public function test_attributes_method()
    {
        $request = new SubscriptionRequest();

        $attributes = $request->attributes();

        $this->assertIsArray($attributes);
        $this->assertArrayHasKey('name', $attributes);
        $this->assertArrayHasKey('renewal_at', $attributes);
    }
}
