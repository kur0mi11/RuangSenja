<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Pastikan pengguna yang sedang login memiliki peran admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pengguna = auth()->user();

        if (!$pengguna || !$pengguna->isAdmin() || !$pengguna->isAktif()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin dengan akun aktif.');
        }

        return $next($request);
    }
}
