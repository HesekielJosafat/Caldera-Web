<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah email sudah diverifikasi
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user && !$user->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'Email belum diverifikasi. Silakan cek email Anda untuk verifikasi.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role === 'admin' || $user->role === 'staff') {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            return redirect()->intended(route('branding.home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('branding.home');
    }
}