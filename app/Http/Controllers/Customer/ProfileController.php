<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    /**
     * Menampilkan profile customer
     */
    public function index()
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    /**
     * Update profile customer
     */
    public function update(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        
        // Update menggunakan Query Builder (paling aman)
        $updated = DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'],
                'updated_at' => now(),
            ]);
        
        if ($updated) {
            return redirect()->back()->with('success', 'Profil berhasil diupdate');
        }
        
        return redirect()->back()->with('error', 'Gagal mengupdate profil');
    }

    /**
     * Ganti password
     */
    public function changePassword(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama salah']);
        }

        // Update password
        $updated = DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($validated['new_password']),
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Password berhasil diubah');
        }
        
        return redirect()->back()->with('error', 'Gagal mengubah password');
    }

    /**
     * Form lupa password
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => 'Link reset password telah dikirim ke email Anda'])
            : back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    /**
     * Form reset password
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => Hash::make($password)]);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset, silakan login')
            : back()->withErrors(['email' => 'Token tidak valid']);
    }
}