<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->user = $user;
    }
}
