<?php

namespace App\Exports;

use App\Models\TableReservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate = null, $endDate = null, $status = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    /**
     * Mengambil data dari database
     */
    public function collection()
    {
        $query = TableReservation::query();
        
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Booking',
            'Nama Customer',
            'Email',
            'Telepon',
            'Tanggal Reservasi',
            'Jam Reservasi',
            'Jumlah Tamu',
            'DP (Rp)',
            'Status',
            'Tanggal Dibuat',
            'Tanggal Update'
        ];
    }

    /**
     * Mapping data per baris
     */
    public function map($reservation): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        return [
            $rowNumber,
            $reservation->booking_code,
            $reservation->customer_name,
            $reservation->customer_email,
            $reservation->customer_phone,
            date('d/m/Y', strtotime($reservation->reservation_date)),
            $reservation->reservation_time,
            $reservation->number_of_guests,
            $reservation->down_payment ?? 0,
            $this->getStatusText($reservation->status),
            date('d/m/Y H:i', strtotime($reservation->created_at)),
            date('d/m/Y H:i', strtotime($reservation->updated_at)),
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed'
        ];
        
        return $statuses[$status] ?? $status;
    }
}