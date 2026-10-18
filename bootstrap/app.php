<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'   => \App\Http\Middleware\AdminMiddleware::class,
            'donatur' => \App\Http\Middleware\DonaturMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Data tidak ditemukan -> halaman 404 kustom
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return response()->view('errors.404', [], 404);
        });

        // Sesi / token CSRF kedaluwarsa -> halaman 419 kustom
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return response()->view('errors.419', [], 419);
        });

        // Error tak terduga (database mati, bug, dll) -> halaman 500 kustom
        // Tidak berlaku untuk validasi form & error HTTP (403/404 dst), karena itu ditangani Laravel sendiri.
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof ValidationException || $e instanceof HttpExceptionInterface) {
                return null;
            }
            if (config('app.debug')) {
                return null; // saat development tetap tampilkan detail error untuk debugging
            }
            return response()->view('errors.500', [], 500);
        });
    })->create();
