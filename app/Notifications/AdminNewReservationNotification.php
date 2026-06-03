<?php

namespace App\Notifications;

use App\Models\TableReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNewReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(TableReservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Reservasi Baru!',
            'body' => "Reservasi baru dari {$this->reservation->customer_name} untuk tanggal {$this->reservation->reservation_date} pukul {$this->reservation->reservation_time}",
            'icon' => 'fa-calendar-plus',
            'color' => 'primary',
            'reservation_id' => $this->reservation->id,
            'booking_code' => $this->reservation->booking_code,
            'customer_name' => $this->reservation->customer_name,
            'reservation_date' => $this->reservation->reservation_date,
            'reservation_time' => $this->reservation->reservation_time,
            'number_of_guests' => $this->reservation->number_of_guests,
        ];
    }

        public function verifyPayment($id)
    {
        $reservation = TableReservation::findOrFail($id);
        
        // Update status pembayaran
        $reservation->payment_status = 'paid';
        $reservation->status = 'confirmed';
        $reservation->confirmed_at = now();
        $reservation->save();

        // 🔔 KIRIM NOTIFIKASI KE CUSTOMER 🔔
        $this->sendPaymentVerifiedNotification($reservation);

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
            
            \Illuminate\Support\Facades\Log::info('Notifikasi pembayaran diverifikasi dikirim ke customer', [
                'customer_id' => $customer->id,
                'customer_email' => $customer->email,
                'booking_code' => $reservation->booking_code
            ]);
        } else {
            \Illuminate\Support\Facades\Log::warning('Customer tidak ditemukan untuk notifikasi', [
                'booking_code' => $reservation->booking_code,
                'customer_email' => $reservation->customer_email
            ]);
        }
    }
}