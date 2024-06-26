<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->error(
                errors: [],
                message: __('Record Not Found'),
                statusCode: Response::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->error(
                errors: [],
                message: __('Unauthenticated'),
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->error(
                errors: $e->errors(),
                message: __('Form Validation Failed'),
                statusCode: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        });

    })->create();
