<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\TableReservation;
use App\Models\PoolTicket;
use App\Models\User;
use App\Notifications\AdminPaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon; // Pastikan Carbon di-import untuk format tanggal

class PaymentController extends Controller
{
    /**
     * Upload bukti pembayaran untuk TICKET
     */
    public function uploadTicketPayment(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
            'bank_from' => 'required|string',
            'account_name' => 'required|string',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cari tiket berdasarkan kode
        $ticket = PoolTicket::where('ticket_code', $request->ticket_code)->firstOrFail();

        // Upload bukti bayar
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'payment_ticket_' . $ticket->ticket_code . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $ticket->payment_proof = $path;
        }

        // Update data tiket
        $ticket->payment_status = 'payment_verified';
        $ticket->payment_method = $request->bank_from;
        $ticket->save();

        // Buat record di tabel payments
        Payment::create([
            'payment_code' => 'PAY-' . strtoupper(Str::random(10)),
            'payable_type' => PoolTicket::class,
            'payable_id' => $ticket->id,
            'amount' => $ticket->total_amount,
            'payment_type' => 'full_payment',
            'payment_method' => 'transfer',
            'bank_name' => $request->bank_from,
            'account_name' => $request->account_name,
            'payment_proof' => $path,
            'payment_status' => 'pending',
            'notes' => 'Pembayaran tiket',
        ]);

        // Notifikasi ke admin (gunakan AdminPaymentNotification)
        $this->sendNotificationToAdmin($ticket);

        return redirect()->route('customer.tickets')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    /**
     * Upload bukti pembayaran untuk TABLE RESERVATION
     */
    public function uploadTablePayment(Request $request, $bookingCode)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'bank_from' => 'required|string',
            'account_name' => 'required|string',
            // 'transaction_id' dihapus dari validasi karena di form web Anda tidak mewajibkannya
        ]);

        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'payment_' . $reservation->booking_code . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $reservation->payment_proof = $path;
        }

        $reservation->payment_status = 'payment_verified';
        // Menyimpan transaction_id jika dikirim dari Flutter, jika tidak diabaikan
        if ($request->has('transaction_id') && !empty($request->transaction_id)) {
            $reservation->transaction_id = $request->transaction_id;
        }
        $reservation->paid_at = Carbon::now();
        $reservation->save();

        // Buat record di tabel payments
        Payment::create([
            'payment_code' => 'PAY-' . strtoupper(Str::random(10)),
            'payable_type' => TableReservation::class,
            'payable_id' => $reservation->id,
            'amount' => $reservation->down_payment ?? 50000,
            'payment_type' => 'down_payment',
            'payment_method' => 'transfer',
            'bank_name' => $request->bank_from,
            'account_name' => $request->account_name,
            'payment_proof' => $path,
            'payment_status' => 'pending',
            'notes' => 'Pembayaran DP reservasi',
        ]);

        // Notifikasi ke admin (gunakan AdminPaymentNotification)
        $this->sendNotificationToAdmin($reservation);

        // --- MULAI PERUBAHAN UNTUK FLUTTER MOBILE API ---
        
        // 1. Buat pesan WhatsApp yang rapi (Sama seperti web)
        $dpAmount = $reservation->down_payment ?? 50000;
        $formattedDate = Carbon::parse($reservation->reservation_date)->format('d F Y');
        $formattedTime = Carbon::parse($reservation->paid_at)->format('d M Y H:i:s');
        $proofUrl = asset('storage/' . $path);
        
        $waMessage = "✅ *KONFIRMASI PEMBAYARAN DP - CALDERA RESTO*\n\n" .
                     "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                     "📋 *KODE BOOKING:* {$reservation->booking_code}\n\n" .
                     "👤 *DATA CUSTOMER*\n" .
                     "──────────────────\n" .
                     "Nama: {$reservation->customer_name}\n" .
                     "WhatsApp: {$reservation->customer_phone}\n\n" .
                     "🍽️ *DETAIL RESERVASI*\n" .
                     "──────────────────\n" .
                     "📅 Tanggal: {$formattedDate}\n" .
                     "🕐 Jam: {$reservation->reservation_time}\n" .
                     "👥 Jumlah Tamu: {$reservation->number_of_guests} orang\n\n" .
                     "💰 *PEMBAYARAN DP*\n" .
                     "──────────────────\n" .
                     "💵 Jumlah DP: Rp " . number_format($dpAmount, 0, ',', '.') . "\n" .
                     "🆔 ID Transaksi: " . ($reservation->transaction_id ?? '-') . "\n" .
                     "⏰ Waktu Transfer: {$formattedTime}\n\n" .
                     "📎 *BUKTI TRANSFER:*\n" .
                     "──────────────────\n" .
                     "📱 Link Bukti Bayar: {$proofUrl}\n\n" .
                     "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                     "🙏 Mohon segera dikonfirmasi. Terima kasih!";

        $waUrl = 'https://wa.me/6285272997806?text=' . urlencode($waMessage);

        // 2. Cek apakah ini request dari API (Mobile Flutter)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload',
                'wa_url' => $waUrl
            ]);
        }

        // Jika dari Web Browser biasa
        return redirect()->route('customer.reservations')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.')
            ->with('wa_url', $waUrl);
            
        // --- AKHIR PERUBAHAN ---
    }

    /**
     * Kirim notifikasi ke admin (untuk tiket atau reservasi)
     */
    private function sendNotificationToAdmin($item)
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            try {
                $admin->notify(new AdminPaymentNotification($item));
            } catch (\Throwable $e) {
                Log::error('Failed sending admin notification', [
                    'admin_id' => $admin->id ?? null,
                    'type' => $item instanceof TableReservation ? 'reservation' : 'ticket',
                    'error' => $e->getMessage()
                ]);
            }
        }

        $type = $item instanceof TableReservation ? 'reservasi' : 'tiket';
        $code = $item instanceof TableReservation ? $item->booking_code : $item->ticket_code;
        
        Log::info("Notifikasi ke admin: Bukti pembayaran {$type} baru", [
            'code' => $code,
            'customer_name' => $item->customer_name
        ]);
    }

    /**
     * Upload bukti pembayaran (UNIFIED METHOD - untuk legacy)
     */
    public function uploadProof(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|string',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_method' => 'required|in:transfer,credit_card,e_wallet',
            'bank_name' => 'required_if:payment_method,transfer|nullable|string',
            'account_number' => 'required_if:payment_method,transfer|nullable|string',
            'account_name' => 'required_if:payment_method,transfer|nullable|string',
            'amount' => 'required|numeric|min:0'
        ]);
        
        // Cari data (reservasi atau tiket)
        $reservation = TableReservation::where('booking_code', $validated['booking_code'])->first();
        $ticket = PoolTicket::where('ticket_code', $validated['booking_code'])->first();
        
        $payable = $reservation ?? $ticket;
        
        if (!$payable) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
        
        // Upload file
        $file = $request->file('payment_proof');
        $filename = 'payment_' . $validated['booking_code'] . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment_proofs', $filename, 'public');
        
        try {
            DB::beginTransaction();
            
            // Buat record payment
            Payment::create([
                'payment_code' => 'PAY-' . strtoupper(uniqid()),
                'payable_type' => get_class($payable),
                'payable_id' => $payable->id,
                'amount' => $validated['amount'],
                'payment_type' => $reservation ? 'down_payment' : 'full_payment',
                'payment_method' => $validated['payment_method'],
                'bank_name' => $validated['bank_name'] ?? null,
                'account_number' => $validated['account_number'] ?? null,
                'account_name' => $validated['account_name'] ?? null,
                'payment_proof' => $path,
                'payment_status' => 'pending'
            ]);
            
            // Update status payable
            if ($reservation) {
                $reservation->update([
                    'payment_status' => 'payment_verified',
                    'payment_proof' => $path
                ]);
            } else {
                $ticket->update([
                    'payment_status' => 'payment_verified',
                    'payment_proof' => $path
                ]);
            }
            
            // Notifikasi ke admin
            $this->sendNotificationToAdmin($payable);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Upload proof error: ' . $e->getMessage());
            return back()->with('error', 'Gagal upload bukti: ' . $e->getMessage());
        }
    }
    
    /**
     * Cek status pembayaran
     */
    public function status($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->first();
        $ticket = PoolTicket::where('ticket_code', $bookingCode)->first();
        $data = $reservation ?? $ticket;
        
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        
        return response()->json([
            'booking_code' => $bookingCode,
            'payment_status' => $data->payment_status,
            'status' => $data->status,
            'amount' => $reservation ? ($data->down_payment ?? 50000) : $data->total_amount
        ]);
    }
}