<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

/**
 * Class RegisterControllerTest
 */
class RegisterControllerTest extends BaseTestCase
{
    use WithFaker;

    public function test_should_register_successfully()
    {
        $password = bcrypt(123456789);
        $userData = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->json('POST', '/api/auth/register', $userData);

        $response->assertJsonStructure([
            'statusCode',
            'data',
            'message',
        ]);
    }

    public function test_should_not_register_with_invalid_email()
    {
        $password = bcrypt('password123');
        $userData = [
            'name' => $this->faker->firstName,
            'email' => 'invalid_email',
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->json('POST', '/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function test_shot_not_register_with_duplicate_email()
    {
        $existingUser = User::factory()->create();

        $password = bcrypt('password123');
        $userData = [
            'name' => $this->faker->firstName,
            'email' => $existingUser->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->json('POST', '/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function test_should_not_register_with_mismatched_passwords()
    {
        $password = bcrypt('password123');
        $userData = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => 'different_password',
        ];

        $response = $this->json('POST', '/api/auth/register', $userData);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'password',
                ],
            ]);
    }
}
