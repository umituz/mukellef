<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\BaseTestCase;

class BaseRepositoryTest extends BaseTestCase
{
    use RefreshDatabase;

    public function test_get_method_returns_all_data()
    {
        User::factory()->create();

        $userRepository = new BaseRepository(new User);
        $users = $userRepository->get();

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertGreaterThan(0, $users->count());
    }

    public function test_create_method_inserts_new_record()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ];

        $userRepository = new BaseRepository(new User);
        $user = $userRepository->create($userData);

        $this->assertNotNull($user->id);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_findBy_method_returns_related_record()
    {
        $user = User::factory()->create();

        $userRepository = new BaseRepository(new User);
        $foundUser = $userRepository->findBy('email', $user->email);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function test_total_method_returns_total_record_count()
    {
        User::factory()->count(3)->create();

        $userRepository = new BaseRepository(new User);
        $totalUsers = $userRepository->total();

        $this->assertEquals(3, $totalUsers);
    }

    public function test_update_method_updates_existing_record()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $userRepository = new BaseRepository(new User);
        $userRepository->update($user->id, $updatedData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_delete_method_deletes_record()
    {
        $user = User::factory()->create();

        $userRepository = new BaseRepository(new User);
        $userRepository->delete('id', $user->id);

        $deletedUser = User::find($user->id);
        $this->assertNull($deletedUser);
    }

    public function test_firstOrCreate_method_creates_new_record_if_not_exists()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ];

        $userRepository = new BaseRepository(new User);
        $user = $userRepository->firstOrCreate('email', $userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['email'], $user->email);
    }

    public function test_firstOrCreate_method_returns_existing_record_if_exists()
    {
        $user = User::factory()->create();

        $userRepository = new BaseRepository(new User);
        $foundUser = $userRepository->firstOrCreate('email', [
            'email' => $user->email,
            'name' => 'Jane Doe',
        ]);

        $this->assertEquals($user->id, $foundUser->id);
        $this->assertEquals($user->name, $foundUser->name);
    }

    public function test_exists_method_returns_false_if_record_does_not_exist()
    {
        $userRepository = new BaseRepository(new User);
        $exists = $userRepository->exists('id', 9999); // A non-existent ID

        $this->assertFalse($exists);
    }

    public function test_find_method_returns_record_if_exists()
    {
        $user = User::factory()->create();

        $userRepository = new BaseRepository(new User);
        $foundUser = $userRepository->find($user->id);

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function test_find_method_throws_exception_if_record_does_not_exist()
    {
        $this->expectException(ModelNotFoundException::class);

        $userRepository = new BaseRepository(new User);
        $userRepository->find(9999);
    }

    public function test_paginate_method_returns_paginated_records()
    {
        User::factory()->count(10)->create();

        $userRepository = new BaseRepository(new User);
        $paginatedUsers = $userRepository->paginate(5);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $paginatedUsers);
        $this->assertEquals(5, $paginatedUsers->perPage());
        $this->assertEquals(10, $paginatedUsers->total());
    }
}
