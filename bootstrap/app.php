<?php

use Http\Client\Exception\HttpException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(function (HttpException $exception) {
        //     if ($exception->getStatusCode() == 404) {
        //         return response()->view("error.error-404", [], 404);
        //     }
        // });
        $exceptions->render(function (Throwable $e) {
            if ($e->getStatusCode() == 404) {
                return response()->view("error.error-404", [], 404);
            }
            if ($e->getStatusCode() == 403) {
                return response()->view("error.error-403", [], 403);
            }
            if ($e->getStatusCode() == 500) {
                return response()->view("error.error-500", [], 500);
            }
        });
    })->create();
