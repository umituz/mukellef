<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    /**
     * Test validation rules.
     *
     * @return void
     */
    public function test_validation_rules()
    {
        $request = new LoginRequest();

        $this->assertEquals([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], $request->rules());
    }

    /**
     * Test validation messages.
     *
     * @return void
     */
    public function test_validation_messages()
    {
        $request = new LoginRequest();

        $expectedMessages = [
            'email.required' => Lang::get('The email field is required.'),
            'email.string' => Lang::get('The email must be a string.'),
            'email.email' => Lang::get('The email must be a valid email address.'),
            'email.exists' => Lang::get('The selected email is invalid.'),
            'password.required' => Lang::get('The password field is required.'),
            'password.string' => Lang::get('The password must be a string.'),
            'password.min' => Lang::get('The password must be at least :min characters.'),
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
        $request = new LoginRequest();

        $expectedAttributes = [
            'email' => Lang::get('Email'),
            'password' => Lang::get('Password'),
        ];

        $this->assertEquals($expectedAttributes, $request->attributes());
    }
}
