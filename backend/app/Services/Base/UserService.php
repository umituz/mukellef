<?php

namespace App\Services\Base;

use App\Http\Resources\UserDetailResource;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return mixed
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function getUserDetails($user)
    {
        $user->load('subscriptions', 'transactions');

        return new UserDetailResource($user);
    }
}
