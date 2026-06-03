<?php
// app/Notifications/PaymentVerifiedNotification.php

namespace App\Notifications;

use App\Models\TableReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
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
            'type' => 'payment_verified_by_admin',
            'booking_code' => $this->reservation->booking_code,
            'title' => '✅ Pembayaran Telah Diverifikasi!',
            'body' => 'Pembayaran DP untuk reservasi ' . $this->reservation->booking_code . 
                      ' telah diverifikasi oleh admin. Reservasi Anda sekarang sudah dikonfirmasi. Terima kasih!',
            'icon' => 'fa-check-circle',
            'color' => 'success',
            'url' => route('reservation.table.view', $this->reservation->booking_code),
            'verified_at' => now()->toIso8601String()
        ];
    }
}