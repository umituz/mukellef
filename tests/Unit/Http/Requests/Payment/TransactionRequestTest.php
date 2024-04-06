<?php

namespace Tests\Unit\Http\Requests\Payment;

use App\Http\Requests\Payment\TransactionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class TransactionRequestTest extends TestCase
{
    public function test_authorize_method()
    {
        $user = User::factory()->create();

        $request = new TransactionRequest();

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $this->assertTrue($request->authorize());
    }

    /**
     * Test validation rules.
     *
     * @return void
     */
    public function test_validation_rules()
    {
        $request = new TransactionRequest();

        $this->assertEquals([
            'subscription_id' => 'required|exists:subscriptions,id',
            'price' => 'required|numeric|min:0',
        ], $request->rules());
    }

    /**
     * Test validation messages.
     *
     * @return void
     */
    public function test_validation_messages()
    {
        $request = new TransactionRequest();

        $expectedMessages = [
            'subscription_id.required' => Lang::get('Subscription ID is required.'),
            'subscription_id.exists' => Lang::get('Subscription not found.'),
            'price.required' => Lang::get('Price is required.'),
            'price.numeric' => Lang::get('Price must be a number.'),
            'price.min' => Lang::get('Price must be greater than or equal to 0.'),
        ];

        $this->assertEquals($expectedMessages, $request->messages());
    }

    /**
     * Test validation attributes.
     *
     * @return void
     */
    public function test_validation_attributes()
    {
        $request = new TransactionRequest();

        $expectedAttributes = [
            'subscription_id' => Lang::get('Subscription ID'),
            'price' => Lang::get('Price'),
        ];

        $this->assertEquals($expectedAttributes, $request->attributes());
    }
}
