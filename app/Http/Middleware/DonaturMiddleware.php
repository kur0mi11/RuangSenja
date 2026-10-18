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
        $pengguna = auth()->user();

        if (!$pengguna || !$pengguna->isDonatur() || !$pengguna->isAktif()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk donatur dengan akun aktif.');
        }

        return $next($request);
    }
}
