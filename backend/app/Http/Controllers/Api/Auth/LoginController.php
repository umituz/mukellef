<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LoginController
 */
class LoginController extends BaseController
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (! auth()->attempt($request->only('email', 'password'))) {
            return $this->validationWarning([
                'email' => __('The provided credentials are incorrect!'),
            ], __('Form Validation Failed'));
        }

        $data = $this->loginService->login($request);

        return $this->ok($data, __('User Logged In'));
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->loginService->logout($request);

        return $this->ok([], __('Logout successful'));
    }
}
