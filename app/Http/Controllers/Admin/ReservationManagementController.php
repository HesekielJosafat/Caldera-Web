<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use App\Models\User;
use App\Notifications\ReservationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PaymentVerifiedNotification;

class ReservationManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = TableReservation::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->date);
        }
        
        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('booking_code', 'like', '%' . $request->search . '%');
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        
        return view('admin.reservations.index', compact('reservations', 'statuses'));
    }
    
    public function show(TableReservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }
    
    public function confirm(TableReservation $reservation)
    {
        try {
            DB::beginTransaction();
            
            $reservation->update([
                'status' => 'confirmed',
                'confirmed_at' => now()
            ]);
            
            // 🔥 Kirim notifikasi konfirmasi ke customer
            $customer = User::where('email', $reservation->customer_email)->first();
            if ($customer) {
                $customer->notify(new ReservationNotification($reservation, 'confirmed'));
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Reservasi berhasil dikonfirmasi');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal konfirmasi: ' . $e->getMessage());
        }
    }
    
    public function cancel(Request $request, TableReservation $reservation)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string'
        ]);
        
        try {
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $validated['cancellation_reason']
            ]);
            
            // 🔥 Kirim notifikasi pembatalan ke customer
            $customer = User::where('email', $reservation->customer_email)->first();
            if ($customer) {
                $customer->notify(new ReservationNotification($reservation, 'cancelled'));
            }
            
            return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan: ' . $e->getMessage());
        }
    }
    
    /**
     * Export reservations to CSV
     */
    public function export(Request $request)
    {
        $reservations = TableReservation::query()
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->start_date, function($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->end_date, function($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->get();
        
        $filename = 'reservations_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Header CSV
        fputcsv($handle, [
            'ID', 'Kode Booking', 'Nama Customer', 'Email', 'Telepon',
            'Tanggal Reservasi', 'Jam', 'Jumlah Tamu', 'DP', 'Status',
            'Tanggal Dibuat'
        ]);
        
        // Data
        foreach ($reservations as $reservation) {
            fputcsv($handle, [
                $reservation->id,
                $reservation->booking_code,
                $reservation->customer_name,
                $reservation->customer_email,
                $reservation->customer_phone,
                $reservation->reservation_date,
                $reservation->reservation_time,
                $reservation->number_of_guests,
                $reservation->down_payment ?? 0,
                $reservation->status,
                $reservation->created_at,
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

        /**
     * Verifikasi pembayaran reservasi (dipanggil oleh admin)
     */
    public function verifyPayment($id)
    {
        $reservation = TableReservation::findOrFail($id);
        
        // Cek apakah statusnya payment_verified
        if ($reservation->payment_status !== 'payment_verified') {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid untuk diverifikasi.');
        }
        
        // Update status pembayaran dan reservasi
        $reservation->payment_status = 'paid';
        $reservation->status = 'confirmed';
        $reservation->confirmed_at = now();
        $reservation->save();

        // 🔔 KIRIM NOTIFIKASI KE CUSTOMER (HANYA SETELAH ADMIN VERIFIKASI) 🔔
        $this->sendPaymentVerifiedNotification($reservation);

        Log::info('Admin verifikasi pembayaran', [
            'admin_id' => Auth::id(),
            'booking_code' => $reservation->booking_code,
            'customer_email' => $reservation->customer_email
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi dan reservasi dikonfirmasi.');
    }

    /**
     * Kirim notifikasi ke customer bahwa pembayaran sudah diverifikasi
     */
    private function sendPaymentVerifiedNotification(TableReservation $reservation)
    {
        // Cari customer berdasarkan email atau user_id
        $customer = null;
        
        if ($reservation->user_id) {
            $customer = \App\Models\User::find($reservation->user_id);
        } elseif ($reservation->customer_email) {
            $customer = \App\Models\User::where('email', $reservation->customer_email)->first();
        }

        if ($customer) {
            $customer->notify(new PaymentVerifiedNotification($reservation));
            
            Log::info('Notifikasi pembayaran diverifikasi dikirim ke customer', [
                'customer_id' => $customer->id,
                'customer_email' => $customer->email,
                'booking_code' => $reservation->booking_code
            ]);
        } else {
            Log::warning('Customer tidak ditemukan untuk notifikasi', [
                'booking_code' => $reservation->booking_code,
                'customer_email' => $reservation->customer_email
            ]);
        }
    }
}