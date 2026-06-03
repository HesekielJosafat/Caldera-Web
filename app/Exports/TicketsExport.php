<?php

namespace App\Exports;

use App\Models\PoolTicket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = PoolTicket::query();
        
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Tiket',
            'Nama Customer',
            'Email',
            'Telepon',
            'Tanggal Kunjungan',
            'Jenis Tiket',
            'Jumlah Tiket',
            'Harga per Tiket',
            'Total Harga',
            'Status Pembayaran',
            'Status Tiket',
            'Tanggal Dibeli'
        ];
    }

    public function map($ticket): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $ticketTypes = [
            'adult' => 'Dewasa',
            'child' => 'Anak-anak',
            'family' => 'Keluarga'
        ];
        
        return [
            $rowNumber,
            $ticket->ticket_code,
            $ticket->customer_name,
            $ticket->customer_email,
            $ticket->customer_phone,
            date('d/m/Y', strtotime($ticket->visit_date)),
            $ticketTypes[$ticket->ticket_type] ?? $ticket->ticket_type,
            $ticket->number_of_tickets,
            $ticket->price_per_ticket,
            $ticket->total_amount,
            $ticket->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar',
            $this->getTicketStatusText($ticket->status),
            date('d/m/Y H:i', strtotime($ticket->created_at)),
        ];
    }

    private function getTicketStatusText($status)
    {
        $statuses = [
            'active' => 'Aktif',
            'used' => 'Digunakan',
            'expired' => 'Kadaluarsa',
            'cancelled' => 'Dibatalkan'
        ];
        
        return $statuses[$status] ?? $status;
    }
}