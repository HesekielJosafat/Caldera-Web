<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use App\Notifications\ReservationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TableReservationController extends Controller
{
    const MIN_DAYS_AHEAD = 1;
    const MAX_DAYS_AHEAD = 30;
    const CALDERA_WHATSAPP_NUMBER = '6285272997806';
    const DP_AMOUNT = 50000;

    public function create()
    {
        $minDate = Carbon::today()->addDays(self::MIN_DAYS_AHEAD)->format('Y-m-d');
        $maxDate = Carbon::today()->addDays(self::MAX_DAYS_AHEAD)->format('Y-m-d');

        return view('reservation.table.create', compact('minDate', 'maxDate'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'number_of_guests' => 'required|integer|min:1',
        ]);

        $count = TableReservation::whereDate('reservation_date', $request->reservation_date)
            ->where('reservation_time', $request->reservation_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $maxPerSlot = 10;
        $available  = $maxPerSlot - $count;

        return response()->json([
            'available' => $available > 0,
            'remaining' => max(0, $available),
            'message'   => $available > 0
                ? "✅ Tersedia {$available} slot untuk waktu ini"
                : '❌ Slot penuh untuk waktu ini, silakan pilih jam lain'
        ]);
    }

    public function store(Request $request)
    {
        $minDate = Carbon::today()->addDays(self::MIN_DAYS_AHEAD)->format('Y-m-d');
        $maxDate = Carbon::today()->addDays(self::MAX_DAYS_AHEAD)->format('Y-m-d');

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:255',
            'reservation_date' => "required|date|after_or_equal:{$minDate}|before_or_equal:{$maxDate}",
            'reservation_time' => 'required|string',
            'number_of_guests' => 'required|integer|min:1|max:50',
            'special_requests' => 'nullable|string|max:500',
        ], [
            'reservation_date.after_or_equal' => 'Reservasi minimal H+1 dari hari ini.',
            'reservation_date.before_or_equal' => 'Reservasi maksimal 30 hari ke depan.',
        ]);

        // GENERATE BOOKING CODE
        $bookingCode = 'RES-' . strtoupper(Str::random(8));
        
        while (TableReservation::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'RES-' . strtoupper(Str::random(8));
        }

        // Simpan ke database
        $reservation = TableReservation::create([
            'booking_code'     => $bookingCode,
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_email'   => $validated['customer_email'] ?? null,
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'number_of_guests' => $validated['number_of_guests'],
            'special_requests' => $validated['special_requests'] ?? null,
            'status'           => 'pending',
            'payment_status'   => 'waiting_payment',
            'down_payment'     => self::DP_AMOUNT,
            'user_id'          => Auth::id(),
        ]);

        // 🔔 KIRIM NOTIFIKASI KE USER (Reservasi Baru Dibuat) — guard notify()
        if (Auth::check()) {
            $user = Auth::user();
            if (is_object($user) && method_exists($user, 'notify')) {
                $user->notify(new ReservationNotification($reservation, 'created'));
            } else {
                Log::warning('TableReservationController: user not notifiable on create', ['user' => $user?->id ?? null]);
            }
        }

        // LOG untuk admin
        $this->logReservationToAdmin($reservation);
        
        // Buat pesan WhatsApp
        $message = $this->buildWhatsAppMessage($reservation);
        $waUrl = 'https://wa.me/' . self::CALDERA_WHATSAPP_NUMBER . '?text=' . urlencode($message);

        return redirect()->route('reservation.table.payment', $reservation->booking_code)
            ->with('success', 'Reservasi berhasil dibuat! Silakan lakukan pembayaran DP Rp ' . number_format(self::DP_AMOUNT, 0, ',', '.') . '.')
            ->with('wa_url', $waUrl);
    }

    public function paymentInstruction($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();
        
        $bankAccounts = [
            [
                'bank' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'Caldera Resto & Pool',
            ],
            [
                'bank' => 'MANDIRI',
                'account_number' => '9876543210',
                'account_name' => 'Caldera Resto & Pool',
            ],
            [
                'bank' => 'BRI',
                'account_number' => '5678901234',
                'account_name' => 'Caldera Resto & Pool',
            ]
        ];
        
        $dpAmount = self::DP_AMOUNT;
        
        return view('reservation.table.payment', compact('reservation', 'bankAccounts', 'dpAmount'));
    }

    public function uploadPaymentProof(Request $request, $bookingCode)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'bank_from' => 'required|string',
            'account_name' => 'required|string',
            'transaction_id' => 'nullable|string'
        ]);

        $reservation = TableReservation::where('booking_code', $bookingCode)
            ->where('payment_status', 'waiting_payment')
            ->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'payment_' . $reservation->booking_code . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $reservation->payment_proof = $path;
        }

        $reservation->payment_status = 'payment_verified'; // Status: menunggu verifikasi admin
        $reservation->transaction_id = $request->transaction_id ?? 'TRX-' . strtoupper(Str::random(10));
        $reservation->paid_at = Carbon::now();
        $reservation->save();

        // 🔔 HAPUS ATAU COMMENT NOTIFIKASI INI 🔔
        // Jangan kirim notifikasi "payment_verified" ke customer
        // Notifikasi hanya dikirim setelah admin memverifikasi
        
        // KIRIM NOTIFIKASI KE ADMIN (bukan ke customer)
        $this->sendNotificationToAdmin($reservation);
        
        // Buat pesan WhatsApp untuk admin (opsional)
        $waMessage = $this->buildPaymentConfirmationMessage($reservation);
        $waUrl = 'https://wa.me/' . self::CALDERA_WHATSAPP_NUMBER . '?text=' . urlencode($waMessage);

        return redirect()->route('reservation.table.whatsapp', $reservation->booking_code)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.')
            ->with('wa_url', $waUrl);
    }

    /**
     * Kirim notifikasi ke admin bahwa ada bukti pembayaran baru
     */
    private function sendNotificationToAdmin(TableReservation $reservation)
    {
        $admins = \App\Models\User::where('role', 'admin')->get();
        $notificationClass = \App\Notifications\AdminPaymentNotification::class;

        if (!class_exists($notificationClass)) {
            Log::error('Notification class not found', ['class' => $notificationClass]);
            return;
        }

        foreach ($admins as $admin) {
            if (is_object($admin) && method_exists($admin, 'notify')) {
                try {
                    $admin->notify(new $notificationClass($reservation));
                } catch (\Throwable $e) {
                    Log::error('Failed sending admin payment notification', ['admin' => $admin?->id ?? null, 'error' => $e->getMessage()]);
                }
            } else {
                Log::warning('Admin not notifiable', ['admin' => $admin?->id ?? null]);
            }
        }

        Log::info('Notifikasi ke admin: Bukti pembayaran baru untuk reservasi ' . $reservation->booking_code);
    }

    public function redirectToWhatsApp($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();
        $waMessage = $this->buildPaymentConfirmationMessage($reservation);
        $waUrl = 'https://wa.me/' . self::CALDERA_WHATSAPP_NUMBER . '?text=' . urlencode($waMessage);
        
        return view('reservation.table.whatsapp', compact('reservation', 'waUrl'));
    }

    /**
     * Confirm reservation (biasanya dipanggil oleh admin)
     */
    public function confirm($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();
        
        $reservation->update([
            'status' => 'confirmed',
            'confirmed_at' => Carbon::now()
        ]);

        // 🔔 KIRIM NOTIFIKASI KE USER (Reservasi Dikonfirmasi) 🔔
        if ($reservation->user_id) {
            $user = \App\Models\User::find($reservation->user_id);
            if ($user) {
                if (is_object($user) && method_exists($user, 'notify')) {
                    $user->notify(new ReservationNotification($reservation, 'confirmed'));
                } else {
                    Log::warning('TableReservationController: user not notifiable on confirm', ['user' => $user?->id ?? null]);
                }
            }
        }

        return redirect()->back()->with('success', 'Reservasi berhasil dikonfirmasi');
    }

    public function view($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();
        return view('reservation.table.view', compact('reservation'));
    }

    public function cancel($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => Carbon::now()
        ]);

        // 🔔 KIRIM NOTIFIKASI KE USER (Reservasi Dibatalkan) — guard notify()
        if (Auth::check()) {
            $user = Auth::user();
            if (is_object($user) && method_exists($user, 'notify')) {
                $user->notify(new ReservationNotification($reservation, 'cancelled'));
            } else {
                Log::warning('TableReservationController: user not notifiable on cancelled', ['user' => $user?->id ?? null]);
            }
        }

        return redirect()->route('customer.reservations')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function success($bookingCode)
    {
        $reservation = TableReservation::where('booking_code', $bookingCode)->firstOrFail();
        $message = $this->buildWhatsAppMessage($reservation);
        $waUrl = 'https://wa.me/' . self::CALDERA_WHATSAPP_NUMBER . '?text=' . urlencode($message);

        return view('reservation.table.success', compact('reservation', 'waUrl'));
    }

    private function buildPaymentConfirmationMessage(TableReservation $reservation): string
    {
        $paymentProofUrl = $reservation->payment_proof ? asset('storage/' . $reservation->payment_proof) : 'Tidak ada bukti';
        
        return "✅ *KONFIRMASI PEMBAYARAN DP - CALDERA RESTO*\n\n" .
               "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
               "📋 *KODE BOOKING:* {$reservation->booking_code}\n\n" .
               "👤 *DATA CUSTOMER*\n" .
               "──────────────────\n" .
               "Nama: {$reservation->customer_name}\n" .
               "WhatsApp: {$reservation->customer_phone}\n\n" .
               "🍽️ *DETAIL RESERVASI*\n" .
               "──────────────────\n" .
               "📅 Tanggal: " . Carbon::parse($reservation->reservation_date)->format('d F Y') . "\n" .
               "🕐 Jam: {$reservation->reservation_time}\n" .
               "👥 Jumlah Tamu: {$reservation->number_of_guests} orang\n\n" .
               "💰 *PEMBAYARAN DP*\n" .
               "──────────────────\n" .
               "💵 Jumlah DP: Rp " . number_format(self::DP_AMOUNT, 0, ',', '.') . "\n" .
               "🆔 ID Transaksi: {$reservation->transaction_id}\n" .
               "⏰ Waktu Transfer: " . Carbon::parse($reservation->paid_at)->format('d M Y H:i:s') . "\n\n" .
               "📎 *BUKTI TRANSFER:*\n" .
               "──────────────────\n" .
               "📱 Link Bukti Bayar: {$paymentProofUrl}\n\n" .
               "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
               "🙏 Mohon segera dikonfirmasi. Terima kasih!";
    }

    private function buildWhatsAppMessage(TableReservation $reservation): string
    {
        return "Halo Caldera Resto & Pool 👋\n\n" .
               "Saya ingin konfirmasi reservasi meja:\n\n" .
               "📋 *Kode Booking:* {$reservation->booking_code}\n" .
               "👤 *Nama:* {$reservation->customer_name}\n" .
               "📞 *No. HP:* {$reservation->customer_phone}\n" .
               "📅 *Tanggal:* " . Carbon::parse($reservation->reservation_date)->format('d M Y') . "\n" .
               "🕐 *Jam:* {$reservation->reservation_time}\n" .
               "👥 *Jumlah Tamu:* {$reservation->number_of_guests} orang\n" .
               ($reservation->special_requests ? "📝 *Catatan:* {$reservation->special_requests}\n" : '') .
               "\nMohon info konfirmasi dan DP yang diperlukan. Terima kasih! 🙏";
    }

    private function logReservationToAdmin(TableReservation $reservation)
    {
        $logMessage = "\n" . str_repeat("=", 60) . "\n";
        $logMessage .= "🔔 RESERVASI MEJA BARU - PERLU KONFIRMASI\n";
        $logMessage .= str_repeat("=", 60) . "\n";
        $logMessage .= "📋 Kode Booking : {$reservation->booking_code}\n";
        $logMessage .= "👤 Nama Customer : {$reservation->customer_name}\n";
        $logMessage .= "📞 No. WhatsApp  : {$reservation->customer_phone}\n";
        $logMessage .= "📅 Tanggal       : " . Carbon::parse($reservation->reservation_date)->format('d F Y') . "\n";
        $logMessage .= "🕐 Jam          : {$reservation->reservation_time}\n";
        $logMessage .= "👥 Jumlah Tamu   : {$reservation->number_of_guests} orang\n";
        
        if ($reservation->special_requests) {
            $logMessage .= "📝 Catatan Khusus: {$reservation->special_requests}\n";
        }
        
        $logMessage .= str_repeat("-", 60) . "\n";
        $logMessage .= "💡 Tindakan: Hubungi customer untuk konfirmasi\n";
        $logMessage .= "📞 Hubungi via WhatsApp: {$reservation->customer_phone}\n";
        $logMessage .= str_repeat("=", 60) . "\n";
        
        Log::info($logMessage);
        
        $this->saveToWhatsAppLog($reservation);
    }
    
    private function saveToWhatsAppLog(TableReservation $reservation)
    {
        $logFile = storage_path('logs/whatsapp_reservations.log');
        $content = "[" . Carbon::now()->format('Y-m-d H:i:s') . "] " .
                   "Booking: {$reservation->booking_code} | " .
                   "Customer: {$reservation->customer_name} | " .
                   "Phone: {$reservation->customer_phone} | " .
                   "Date: {$reservation->reservation_date} {$reservation->reservation_time}\n";
        
        file_put_contents($logFile, $content, FILE_APPEND);
    }
}