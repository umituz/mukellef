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
        $data = $this->loginService->login($request);

        return array_key_exists('token', $data) ?
            $this->ok($data, __('User Logged In')) :
            $this->error($data['errors'], $data['message'], $data['statusCode']);
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $result = $this->loginService->logout($request);

        return $this->ok($result, __('Logout successful'));
    }
}
