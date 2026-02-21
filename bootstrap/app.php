<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
      ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            // Register custom middleware here
            'role' => App\Http\Middleware\RoleMiddleware::class,
            // Registration custom middleware here
            'registration.complete' => \App\Http\Middleware\EnsureRegistrationCompleted::class,


        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
