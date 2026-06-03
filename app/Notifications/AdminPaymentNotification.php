<?php
// app/Notifications/AdminPaymentNotification.php

namespace App\Notifications;

use App\Models\TableReservation;
use App\Models\PoolTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminPaymentNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $type;

    public function __construct($item)
    {
        if ($item instanceof TableReservation) {
            $this->type = 'reservation';
            $this->data = [
                'code' => $item->booking_code,
                'customer_name' => $item->customer_name,
                'url' => route('admin.reservations.show', $item),
                'title' => '💰 Bukti Pembayaran Reservasi Baru!',
                'body' => 'Customer ' . $item->customer_name . 
                          ' telah mengupload bukti pembayaran DP untuk reservasi ' . 
                          $item->booking_code . '. Silakan verifikasi.',
            ];
        } else {
            // PoolTicket
            $this->type = 'ticket';
            $this->data = [
                'code' => $item->ticket_code,
                'customer_name' => $item->customer_name,
                'url' => route('admin.tickets.show', $item),
                'title' => '🎫 Bukti Pembayaran Tiket Baru!',
                'body' => 'Customer ' . $item->customer_name . 
                          ' telah mengupload bukti pembayaran untuk tiket ' . 
                          $item->ticket_code . '. Silakan verifikasi.',
            ];
        }
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'admin_payment_uploaded',
            'payment_type' => $this->type,
            'code' => $this->data['code'],
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'icon' => 'fa-upload',
            'color' => 'warning',
            'url' => $this->data['url'],
        ];
    }
}