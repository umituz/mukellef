<?php

namespace App\Services\Auth;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepositoryInterface;
use Exception;

/**
 * Class LoginService
 */
class LoginService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     */
    public function login($request)
    {
        $user = $this->userRepository->findBy('email', $request->input('email'));
        $token = $user->createToken('userToken')->plainTextToken;
        $item = new UserResource($user);

        return [
            'user' => $item,
            'token' => $token,
        ];
    }

    public function logout($request): bool
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return true;
        } catch (Exception $exception) {

            return false;
        }
    }
}
