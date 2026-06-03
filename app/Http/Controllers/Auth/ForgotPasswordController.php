<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form input email
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim OTP ke email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => $otp,
                'created_at' => Carbon::now(),
            ]
        );

        $user = User::where('email', $request->email)->first();

        Mail::raw(
            "Halo {$user->name},\n\nKode OTP reset password Anda: {$otp}\n\nBerlaku selama 10 menit.\n\nJika Anda tidak meminta reset password, abaikan email ini.",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode OTP Reset Password - Caldera Resto & Pool');
            }
        );

        return redirect()->route('password.otp.form', ['email' => $request->email])
                         ->with('success', 'Kode OTP telah dikirim ke ' . $request->email);
    }

    /**
     * Tampilkan form input OTP + password baru
     */
    public function showOtpForm(Request $request)
    {
        return view('auth.reset-password-otp', [
            'email' => $request->email ?? $request->query('email'),
        ]);
    }

    /**
     * Verifikasi OTP dan reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users,email',
            'otp'                   => 'required|digits:6',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.'])->withInput();
        }

        // Cek expired (10 menit)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Minta kode baru.'])->withInput();
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
                         ->with('success', 'Password berhasil direset. Silakan login.');
    }
}