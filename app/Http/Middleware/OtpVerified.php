<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
            return redirect()->route('login');
        }

        if (!$user->isOtpVerified()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.',
                    'code'    => 'OTP_NOT_VERIFIED',
                    'data'    => [
                        'redirect' => '/otp/verify',
                    ],
                ], 403);
            }
            return redirect()->route('otp.verify')
                ->with('warning', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return $next($request);
    }
}