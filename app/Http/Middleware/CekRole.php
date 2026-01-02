<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek Role
        // Jika role user tidak sama dengan yang diminta halaman
        if (Auth::user()->role !== $role) {
            
            // Salah kamar? Kita antar ke kamar yang benar
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/customer/dashboard');
            }
        }

        return $next($request);
    }
}