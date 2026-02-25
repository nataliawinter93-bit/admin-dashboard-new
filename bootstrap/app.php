<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/admin.php',
        ],
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        App\Providers\ViewServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    // 404 Not Found
    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => 'Resource not found',
                'status' => 404,
            ], 404);
        }
    });

    // 403 Forbidden
    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
        if ($request->is('api/*') && $e->getStatusCode() === 403) {
            return response()->json([
                'error' => 'Forbidden',
                'status' => 403,
            ], 403);
        }
    });

    // 422 Validation errors
    $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422,
            ], 422);
        }
    });

    // 500 Internal Server Error
    $exceptions->render(function (\Throwable $e, $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => 'Server error',
                'status' => 500,
            ], 500);
        }
    });
})

    ->create();
