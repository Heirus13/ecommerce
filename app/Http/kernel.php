<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Global middleware
    ];

    protected $middlewareGroups = [
        // Middleware groups
    ];

    protected $routeMiddleware = [
        // Other middleware...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}