<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek apakah user sudah login?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil data user saat ini
        $user = Auth::user();

        // 3. Cek apakah role user SAMA DENGAN role yang diminta?
        // (Misal: user role 'customer', tapi mau masuk halaman 'admin')
        if ($user->role !== $role) {
            // Jika beda, tendang ke halaman home atau dashboard masing-masing
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/customer/dashboard');
        }

        // 4. Jika cocok, silakan lanjut
        return $next($request);
    }
}