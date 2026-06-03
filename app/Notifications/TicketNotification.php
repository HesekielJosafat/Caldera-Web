<?php

namespace App\Notifications;

use App\Models\PoolTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $type;

    public function __construct(PoolTicket $ticket, $type = 'purchased')
    {
        $this->ticket = $ticket;
        $this->type = $type;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $messages = [
            'purchased' => [
                'title' => 'Tiket Kolam Dibeli',
                'body' => "Tiket kolam dengan kode {$this->ticket->ticket_code} berhasil dibeli. Silakan lakukan pembayaran.",
                'icon' => 'fa-ticket-alt',
                'color' => 'primary'
            ],
            'paid' => [
                'title' => 'Pembayaran Tiket Diverifikasi',
                'body' => "Pembayaran tiket {$this->ticket->ticket_code} telah diverifikasi. Selamat menikmati kolam!",
                'icon' => 'fa-check-circle',
                'color' => 'success'
            ],
            'used' => [
                'title' => 'Tiket Digunakan',
                'body' => "Tiket kolam dengan kode {$this->ticket->ticket_code} telah digunakan.",
                'icon' => 'fa-swimmer',
                'color' => 'info'
            ]
        ];

        $message = $messages[$this->type] ?? $messages['purchased'];

        return [
            'ticket_id' => $this->ticket->id,
            'ticket_code' => $this->ticket->ticket_code,
            'type' => $this->type,
            'title' => $message['title'],
            'body' => $message['body'],
            'icon' => $message['icon'],
            'color' => $message['color'],
            'time' => now()->toIso8601String()
        ];
    }
}
