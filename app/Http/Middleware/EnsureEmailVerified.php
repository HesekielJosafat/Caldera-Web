<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email belum diverifikasi.'], 403);
            }

            return redirect()->route('verification.notice')
                ->with('warning', 'Anda harus verifikasi email terlebih dahulu sebelum melakukan pemesanan.');
        }

        return $next($request);
    }
}