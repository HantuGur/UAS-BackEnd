<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(_DIR_))
->withRouting(
    web: _DIR_.'/../routes/web.php',
    api: _DIR_.'/../routes/api.php',
    commands: _DIR_.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuthMiddleware::class,
        'customer.auth' => \App\Http\Middleware\CustomerAuthMiddleware::class,
    ]);
})
->withExceptions(function (Exceptions $exceptions): void {
    //
})->create();