<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek apakah role user adalah admin atau staff
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'staff'])) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        return $next($request);
    }
}