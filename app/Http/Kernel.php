<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Handle CORS headers
        \Fruitcake\Cors\HandleCors::class,

        // TrustProxies sets trusted proxies for this application
        \App\Http\Middleware\TrustProxies::class,

        // Prevents requests with invalid signature (e.g., URL Tampering)
        \Illuminate\Http\Middleware\ValidatePostSize::class,

        // Converts empty strings in request input to null
        \App\Http\Middleware\TrimStrings::class,

        // Removes sensitive session data from the request
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // Only required for Laravel apps using `throttle` functionality
            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Limits requests to the API using Laravel RateLimiter
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Standard middleware that authenticates requests
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Handles basic HTTP auth, sometimes used for APIs
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Checks if the user email is verified before proceeding
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Authorizes users to access certain actions within the app
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Enforces URL signature validation on routes
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Enforces rate-limiting policies across requests
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Handles route parameter/model bindings
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // Check the role of the user 


    ];
}
