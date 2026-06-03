<?php

namespace App\Notifications;

use App\Models\PoolTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNewTicketNotification extends Notification
{
    use Queueable;

    protected $ticket;

    public function __construct(PoolTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Tiket Kolam Baru!',
            'body' => "Pembelian tiket baru dari {$this->ticket->customer_name} untuk tanggal {$this->ticket->visit_date}",
            'icon' => 'fa-ticket-alt',
            'color' => 'success',
            'ticket_id' => $this->ticket->id,
            'ticket_code' => $this->ticket->ticket_code,
            'customer_name' => $this->ticket->customer_name,
            'visit_date' => $this->ticket->visit_date,
            'number_of_tickets' => $this->ticket->number_of_tickets,
            'total_amount' => $this->ticket->total_amount,
        ];
    }
}