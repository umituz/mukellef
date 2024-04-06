<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\BaseTestCase;

/**
 * Class LoginControllerTest
 */
class LoginControllerTest extends BaseTestCase
{
    public function test_should_login_successfully()
    {
        $user = User::factory()->create(['password' => bcrypt(123456789)]);
        $userData = ['email' => $user->email, 'password' => '123456789'];

        $response = $this->json('POST', route('login'), $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'statusCode',
                'message',
                'data',
            ]);
    }

    public function test_should_not_login_with_invalid_password()
    {
        $userData = [
            'email' => 'user@example.com',
            'password' => 'wrong_password',
        ];

        $response = $this->json('POST', route('login'), $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_should_not_login_with_invalid_email()
    {
        $userData = [
            'email' => 'invalid_email@example.com',
            'password' => 'password123',
        ];

        $response = $this->json('POST', route('login'), $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_should_not_login_with_non_existent_user()
    {
        $userData = [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ];

        $response = $this->json('POST', route('login'), $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_should_logout_successfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('logout'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'statusCode' => 200,
                'message' => __('Logout successful'),
                'data' => [],
            ]);
    }
}
