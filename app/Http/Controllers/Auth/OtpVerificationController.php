<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailOtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    // Maksimal percobaan OTP yang salah
    const MAX_ATTEMPTS = 5;
    // Lockout duration dalam menit
    const LOCKOUT_MINUTES = 15;
    // Maksimal kirim ulang OTP per jam
    const MAX_RESEND = 3;

    /**
     * Kirim atau Kirim Ulang OTP
     */
    public function send(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Cek apakah user valid/terautentikasi
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Cek apakah sudah diverifikasi
        if ($user->hasVerifiedEmail()) {
            return response()->json(['success' => true, 'message' => 'Email sudah diverifikasi.'], 200);
        }

        // Cek batas kirim ulang OTP (max 3x per jam)
        $resendKey = 'otp_resend_' . $user->id;
        $resendCount = Cache::get($resendKey, 0);

        if ($resendCount >= self::MAX_RESEND) {
            return response()->json([
                'success' => false,
                'message' => 'Anda telah mencapai batas pengiriman OTP. Coba lagi dalam 1 jam.'
            ], 429);
        }

        // Hapus OTP lama agar tidak menumpuk (Menggunakan is_used agar sesuai database)
        EmailOtpVerification::where('user_id', $user->id)->delete();

        // Reset attempt counter
        Cache::forget('otp_attempts_' . $user->id);

        // Generate OTP 6 digit
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtpVerification::create([
            'user_id'    => $user->id,
            'otp'        => $otp,
            'is_used'    => false, // FIXED: Menggunakan 'is_used' sesuai standar Web Anda
            'expires_at' => now()->addMinutes(10),
        ]);

        // Increment resend counter (reset setiap 1 jam)
        Cache::put($resendKey, $resendCount + 1, now()->addHour());

        // TRY-CATCH: Mencegah crash jika settingan SMTP/Email salah
        try {
            Mail::raw(
                "Halo {$user->name},\n\nKode OTP verifikasi email Anda: {$otp}\n\nBerlaku 10 menit.\nJangan berikan kode ini kepada siapapun.",
                function ($message) use ($user) {
                    $message->to((string) $user->email)
                            ->subject('Kode OTP Verifikasi - Caldera Resto & Pool');
                }
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal mengirim email. Pastikan settingan email benar. Error: ' . $e->getMessage()
            ], 500);
        }

        $remaining = self::MAX_RESEND - ($resendCount + 1);

        return response()->json([
            'success' => true,
            'message' => "Kode OTP telah dikirim ke {$user->email}. Sisa percobaan kirim ulang: {$remaining}x"
        ], 200);
    }

    /**
     * Verifikasi Kode OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['success' => true, 'message' => 'Email sudah diverifikasi sebelumnya.'], 200);
        }

        $attemptKey = 'otp_attempts_' . $user->id;
        $lockKey    = 'otp_locked_' . $user->id;

        // Cek apakah user sedang di-lock
        if (Cache::has($lockKey)) {
            $remainingSeconds = Cache::get($lockKey) - time();
            $remainingMinutes = ceil($remainingSeconds / 60);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan gagal. Akun dikunci selama {$remainingMinutes} menit lagi."
            ], 429);
        }

        $attempts = Cache::get($attemptKey, 0);

        // FIXED: Memanggil berdasarkan 'is_used'
        $otpRecord = EmailOtpVerification::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        // Jika OTP salah atau tidak ditemukan
        if (!$otpRecord) {
            $attempts++;
            Cache::put($attemptKey, $attempts, now()->addHour());

            $remaining = self::MAX_ATTEMPTS - $attempts;

            if ($attempts >= self::MAX_ATTEMPTS) {
                // Lock akun sementara
                $lockUntil = time() + (self::LOCKOUT_MINUTES * 60);
                Cache::put($lockKey, $lockUntil, now()->addMinutes(self::LOCKOUT_MINUTES));
                Cache::forget($attemptKey);

                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percobaan gagal. Akun dikunci selama ' . self::LOCKOUT_MINUTES . ' menit.'
                ], 429);
            }

            return response()->json([
                'success' => false,
                'message' => "Kode OTP tidak valid. Sisa percobaan: {$remaining}x"
            ], 400);
        }

        // Jika method isExpired ada di Model, panggil. Jika tidak, pakai cek waktu biasa.
        if (method_exists($otpRecord, 'isExpired') ? $otpRecord->isExpired() : $otpRecord->expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.'
            ], 400);
        }

        // JIKA OTP VALID — reset semua counter
        Cache::forget($attemptKey);
        Cache::forget($lockKey);
        Cache::forget('otp_resend_' . $user->id);

        // Update OTP menjadi sudah terpakai
        $otpRecord->update(['is_used' => true]);
        
        // Tandai email user sudah terverifikasi
        if (method_exists($user, 'markEmailAsVerified')) {
            $user->markEmailAsVerified();
        } else {
            $user->email_verified_at = now();
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi! Selamat datang di Caldera.'
        ], 200);
    }
}