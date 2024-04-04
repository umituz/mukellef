<?php

namespace App\Services\Auth;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

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
        if (! auth()->attempt($request->only('email', 'password'))) {
            return [
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'email' => __('The provided credentials are incorrect!'),
                ],
                'message' => __('Login Failed'),
            ];

        }

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
