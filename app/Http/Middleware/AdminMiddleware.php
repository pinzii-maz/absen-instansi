<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
    {
    // Periksa apakah pengguna sudah login DAN kolom 'is_admin' bernilai true.
    if (auth()->check() && $request->user()->is_admin) {
        // Jika ya, izinkan untuk melanjutkan request.
        return $next($request);
    }

    // Jika tidak, hentikan request dan tampilkan halaman error 403 (Forbidden).
    abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES.');
    }
}
