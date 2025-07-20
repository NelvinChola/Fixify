<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
           // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })


    ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated'], 401)
            : redirect()->to('/login'); // Changed from route('login') to direct URL
    });
    
    // Other exception handlers...
})

    ->withExceptions(function (Exceptions $exceptions) {
        // This is the correct way in Laravel 12
        $exceptions->reportable(function (\Throwable $e) {
            // Report exceptions to your error tracking service
        });
        
        $exceptions->renderable(function (\Throwable $e, \Illuminate\Http\Request $request) {
            // Customize exception rendering
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
        });
    })
    ->create();