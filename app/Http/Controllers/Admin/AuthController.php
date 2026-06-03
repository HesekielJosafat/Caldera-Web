<?php
// app/Http/Controllers/Admin/AuthController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!in_array($user->role, ['admin', 'staff'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses ditolak.']);
            }
            
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}