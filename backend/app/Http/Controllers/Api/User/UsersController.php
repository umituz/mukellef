<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Services\Base\UserService;

class UsersController extends BaseController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $item = $this->userService->getUserDetails($user);

        return $this->ok($item, __('User Details'));
    }
}
