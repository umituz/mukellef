<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    /**
     * Test validation rules.
     *
     * @return void
     */
    public function test_validation_rules()
    {
        $request = new RegisterRequest();

        $this->assertEquals([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email', 'min:9'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ], $request->rules());
    }

    /**
     * Test validation messages.
     *
     * @return void
     */
    public function test_validation_messages()
    {
        $request = new RegisterRequest();

        $expectedMessages = [
            'name.required' => Lang::get('The name field is required.'),
            'name.string' => Lang::get('The name must be a string.'),
            'name.min' => Lang::get('The name must be at least :min characters.'),
            'name.max' => Lang::get('The name may not be greater than :max characters.'),
            'email.required' => Lang::get('The email field is required.'),
            'email.email' => Lang::get('The email must be a valid email address.'),
            'email.unique' => Lang::get('The email has already been taken.'),
            'email.min' => Lang::get('The email must be at least :min characters.'),
            'password.required' => Lang::get('The password field is required.'),
            'password.string' => Lang::get('The password must be a string.'),
            'password.confirmed' => Lang::get('The password confirmation does not match.'),
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
        $request = new RegisterRequest();

        $expectedAttributes = [
            'name' => Lang::get('Name'),
            'email' => Lang::get('Email'),
            'password' => Lang::get('Password'),
        ];

        $this->assertEquals($expectedAttributes, $request->attributes());
    }
}
