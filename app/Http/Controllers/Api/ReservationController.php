<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationNotification;

class ReservationController extends Controller
{
    // Fungsi untuk mobile menyimpan reservasi
    public function store(Request $request)
    {
        try {
            // 1. Validasi Input dari Flutter
            $validated = $request->validate([
                'customer_name'    => 'required|string|max:255',
                'customer_phone'   => 'required|string|max:20',
                'number_of_guests' => 'required|integer|min:1',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required|string',
                'special_requests' => 'nullable|string',
            ]);

            // 2. Generate Booking Code (RES-XXXXXX)
            $bookingCode = 'RES-' . strtoupper(Str::random(8));
            while (TableReservation::where('booking_code', $bookingCode)->exists()) {
                $bookingCode = 'RES-' . strtoupper(Str::random(8));
            }

            // 3. Simpan ke Database
            $reservation = TableReservation::create([
                'booking_code'     => $bookingCode,
                'customer_name'    => $validated['customer_name'],
                'customer_phone'   => $validated['customer_phone'],
                'reservation_date' => $validated['reservation_date'],
                'reservation_time' => $validated['reservation_time'],
                'number_of_guests' => $validated['number_of_guests'],
                'special_requests' => $validated['special_requests'] ?? null,
                'status'           => 'pending',
                'payment_status'   => 'waiting_payment',
                'down_payment'     => 50000, // Hardcode DP sesuai web Anda
                'user_id'          => auth::id(), // Terisi jika user login
            ]);

            $user = Auth::user(); // Menggunakan Auth Facade agar VS Code mengerti
            if ($user) {
                $user->notify(new \App\Notifications\ReservationNotification($reservation, 'created'));
            }


            // 4. KEMBALIKAN JSON KE FLUTTER (Bukan Redirect)
            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat',
                'data'    => $reservation
            ], 201);

        } catch (\Exception $e) {
            // Jika ada error database, tampilkan pesannya (bukan cuma error 500 blank)
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Fungsi tambahan untuk mengambil daftar reservasi user (Jika diperlukan)
    public function index()
    {
        $reservations = TableReservation::where('user_id', auth::id())
                                        ->latest()
                                        ->get();
                                        
        return response()->json([
            'success' => true,
            'data' => $reservations
        ]);
    }
}