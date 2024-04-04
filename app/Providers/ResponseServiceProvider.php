<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function ($data = null, $message = '', $statusCode = null) use ($factory) {
            $statusCode = $statusCode ?? 200;

            $response = [
                'statusCode' => $statusCode,
                'message' => $message,
                'data' => $data,
            ];

            return $factory->json($response, $statusCode);
        });

        $factory->macro('error', function (array $errors = [], $message = '', $statusCode = null) use ($factory) {
            $statusCode = $statusCode ?? 500;

            $response = [
                'statusCode' => $statusCode,
                'message' => $message,
                'errors' => $errors,
            ];

            return $factory->json($response, $statusCode);
        });
    }
}
