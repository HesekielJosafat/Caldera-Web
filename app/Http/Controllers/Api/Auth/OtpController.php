<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailOtpVerification;
use App\Models\User;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function send(Request $request)
    {
        /** @var User|null $user */
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($user->isOtpVerified()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sudah diverifikasi sebelumnya.',
            ]);
        }

        if (!$user->canRequestOtp()) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan OTP. Coba lagi dalam '
                    . $user->otpSendCooldownMinutes() . ' menit.',
                'code'    => 'OTP_RATE_LIMITED',
                'data'    => [
                    'cooldown_minutes' => $user->otpSendCooldownMinutes(),
                ],
            ], 429);
        }

        EmailOtpVerification::where('user_id', $user->id)
            ->where('used', false)
            ->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtpVerification::create([
            'user_id'    => $user->id,
            'otp'        => ($otp),
            'expires_at' => now()->addMinutes(10),
            'used'       => false,
        ]);

        $user->recordOtpSend();

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Halo {$user->name},\n\nKode OTP verifikasi email Anda: {$otp}\n\nBerlaku 10 menit.\nJangan berikan kode ini kepada siapapun.",
                function ($message) use ($user) {
                    $message->to((string) $user->email)
                            ->subject('Kode OTP Verifikasi - Caldera Resto & Pool');
                }
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil dikirim ke ' . $user->email,
            'data'    => [
                'expires_in_minutes' => 10,
            ],
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        /** @var User|null $user */
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($user->isOtpVerified()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sudah diverifikasi sebelumnya.',
            ]);
        }

        $record = EmailOtpVerification::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak valid atau sudah kadaluarsa.',
                'code'    => 'OTP_INVALID',
            ], 422);
        }

        $record->update(['used' => true]);

        $user->update([
            'otp_verified'      => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil diverifikasi.',
            'data'    => [
                'otp_verified' => true,
            ],
        ]);
    }
}