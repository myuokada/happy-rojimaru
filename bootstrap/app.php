<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('admin', [AdminMiddleware::class]);
        // $middleware- is a global variable for middleware
        // appendToGroup - means add to an existing route group
        // 'admin' is the alias of middleware
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
