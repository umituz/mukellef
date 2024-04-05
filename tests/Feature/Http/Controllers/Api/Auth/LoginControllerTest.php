<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\IntegrationBaseTestCase;

/**
 * Class LoginControllerTest
 */
class LoginControllerTest extends IntegrationBaseTestCase
{
    public function test_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt(123456789),
        ]);

        $userData = [
            'email' => $user->email,
            'password' => '123456789',
        ];

        $response = $this->json('POST', '/api/auth/login', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'statusCode',
                'message',
                'data',
            ]);
    }

    public function test_login_with_invalid_password()
    {
        $userData = [
            'email' => 'user@example.com',
            'password' => 'wrong_password',
        ];

        $response = $this->json('POST', '/api/auth/login', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_login_with_invalid_email()
    {
        $userData = [
            'email' => 'invalid_email@example.com',
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/auth/login', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_login_with_nonexistent_user()
    {
        $userData = [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ];

        $response = $this->json('POST', '/api/auth/login', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response
            ->assertStatus(200)
            ->assertJson([
                'statusCode' => 200,
                'message' => __('Logout successful'),
                'data' => [],
            ]);
    }

    public function test_login_with_invalid_credentials()
    {
        $userData = [
            'email' => 'invalid@example.com',
            'password' => 'invalid_password',
        ];

        $response = $this->json('POST', '/api/auth/login', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'statusCode' => 422,
                'errors' => ['email' => [__('The selected email is invalid.')]],
                'message' => __('Form Validation Failed'),
            ]);
    }

}
