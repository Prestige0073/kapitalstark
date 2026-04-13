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
        $middleware->redirectGuestsTo(fn () => route('client.login'));
        $middleware->redirectUsersTo(fn ($request) => $request->user()?->is_admin
            ? route('admin.index')
            : route('dashboard.index'));
        $middleware->alias([
            'is_admin'  => \App\Http\Middleware\IsAdmin::class,
            'is_client' => \App\Http\Middleware\IsClient::class,
        ]);
        $middleware->web(\App\Http\Middleware\SetLocale::class);
        $middleware->web(\App\Http\Middleware\SeoMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
