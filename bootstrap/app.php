<?php

use App\Http\Middleware\SaveIntendedUrl;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(SaveIntendedUrl::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withSchedule( function (Schedule $schedule) {
        $schedule->command('app:send-booking-notification')->everyMinute();
    })->create();
