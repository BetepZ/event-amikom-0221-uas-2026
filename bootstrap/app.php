<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole; // 1. Pastikan class middleware di-import (use) di sini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 2. Daftarkan alias middleware 'role' di sini
        $middleware->alias([
            'role' => CheckRole::class,
        ]);

        // 3. Kecualikan route webhook dari perlindungan CSRF
        $middleware->validateCsrfTokens(except: [
            'payments/midtrans-notification', // Izinkan Midtrans masuk
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
