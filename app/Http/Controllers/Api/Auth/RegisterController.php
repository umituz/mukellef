<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

/**
 * Class RegisterController
 */
class RegisterController extends BaseController
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->registerService->createUser($request);

        return $this->ok($user, __('User Created'));
    }
}
