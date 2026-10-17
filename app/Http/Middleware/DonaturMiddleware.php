<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonaturMiddleware
{
    /**
     * Pastikan pengguna yang sedang login memiliki peran donatur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isDonatur()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk donatur.');
        }

        return $next($request);
    }
}
