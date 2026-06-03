<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar reservasi customer
     */
    public function index()
    {
        $reservations = TableReservation::where('customer_email', Auth::user()->email)
            ->orWhere('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('customer.reservations', compact('reservations'));
    }

    /**
     * Detail reservasi
     */
    public function show($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)
            ->where(function($query) {
                $query->where('customer_email', Auth::user()->email)
                      ->orWhere('user_id', Auth::id());
            })
            ->firstOrFail();
            
        return view('customer.reservation-detail', compact('reservation'));
    }

    /**
     * Batalkan reservasi
     */
    public function cancel($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)
            ->where(function($query) {
                $query->where('customer_email', Auth::user()->email)
                      ->orWhere('user_id', Auth::id());
            })
            ->firstOrFail();

        if ($reservation->status == 'confirmed') {
            return redirect()->back()->with('error', 'Reservasi yang sudah dikonfirmasi tidak dapat dibatalkan');
        }

        $reservation->status = 'cancelled';
        $reservation->cancelled_at = now();
        $reservation->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan');
    }

    
}