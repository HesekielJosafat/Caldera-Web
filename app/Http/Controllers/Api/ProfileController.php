<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    // MENAMPILKAN DATA PROFIL
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    // MENGUPDATE PROFIL / GANTI PASSWORD
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. JIKA USER INGIN MENGUBAH PASSWORD
        if ($request->has('update_type') && $request->update_type === 'password') {
            $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Cek apakah password lama yang dimasukkan benar
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama yang Anda masukkan salah.'
                ], 400); // 400 = Bad Request
            }

            // Simpan password baru (Sudah di-hash otomatis oleh Laravel)
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah.'
            ]);
        }

        // 2. JIKA USER INGIN MENGUBAH PROFIL (Nama & Telepon)
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user // Mengirimkan data user terbaru kembali ke Flutter
        ]);
    }
}