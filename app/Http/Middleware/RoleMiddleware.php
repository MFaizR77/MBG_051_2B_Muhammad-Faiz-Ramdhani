<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login, arahkan ke login
        if (!session('logged_in')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Cek role apakah sesuai
        $userRole = session('role');
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
