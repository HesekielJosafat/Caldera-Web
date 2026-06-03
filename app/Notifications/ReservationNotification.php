<?php

namespace App\Notifications;

use App\Models\TableReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;
    protected $type;

    public function __construct(TableReservation $reservation, $type = 'created')
    {
        $this->reservation = $reservation;
        $this->type = $type;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $messages = [
            'created' => [
                'title' => 'Reservasi Baru Dibuat',
                'body' => "Reservasi meja dengan kode {$this->reservation->booking_code} telah berhasil dibuat. Silakan lakukan pembayaran DP.",
                'icon' => 'fa-calendar-plus',
                'color' => 'primary'
            ],
            'confirmed' => [
                'title' => 'Reservasi Dikonfirmasi',
                'body' => "Reservasi meja dengan kode {$this->reservation->booking_code} telah dikonfirmasi. Selamat menikmati!",
                'icon' => 'fa-check-circle',
                'color' => 'success'
            ],
            'cancelled' => [
                'title' => 'Reservasi Dibatalkan',
                'body' => "Reservasi meja dengan kode {$this->reservation->booking_code} telah dibatalkan.",
                'icon' => 'fa-times-circle',
                'color' => 'danger'
            ],
            'payment_verified' => [
                'title' => 'Pembayaran Diverifikasi',
                'body' => "Pembayaran DP untuk reservasi {$this->reservation->booking_code} telah diverifikasi.",
                'icon' => 'fa-credit-card',
                'color' => 'success'
            ]
        ];

        $message = $messages[$this->type] ?? $messages['created'];

        return [
            'reservation_id' => $this->reservation->id,
            'booking_code' => $this->reservation->booking_code,
            'type' => $this->type,
            'title' => $message['title'],
            'body' => $message['body'],
            'icon' => $message['icon'],
            'color' => $message['color'],
            'time' => now()->toIso8601String()
        ];
    }
}