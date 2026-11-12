<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        // 1. Cek apakah pengguna sudah login atau belum
        if (!auth()->check()) {
            return redirect('login');
        }

        // 2. Ambil role pengguna yang sedang login
        $userRole = auth()->user()->role;

        // 3. Cek apakah role pengguna ada di dalam daftar role yang diizinkan
        if (!empty($roles) && in_array($userRole, (array) $roles)) {
             return $next($request);
             }

        // 4. Jika role tidak cocok, kunci akses dengan error 403
        abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
    }
}