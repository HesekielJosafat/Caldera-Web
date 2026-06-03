<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncomeExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $paymentType;

    public function __construct($startDate = null, $endDate = null, $paymentType = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentType = $paymentType;
    }

    public function collection()
    {
        $query = Payment::where('payment_status', 'verified');
        
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        if ($this->paymentType) {
            $query->where('payment_type', $this->paymentType);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal',
            'Tipe Pembayaran',
            'Metode Pembayaran',
            'Jumlah',
            'Status'
        ];
    }

    public function map($payment): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $paymentTypes = [
            'down_payment' => 'DP Reservasi',
            'full_payment' => 'Full Payment Tiket'
        ];
        
        $paymentMethods = [
            'transfer' => 'Transfer Bank',
            'credit_card' => 'Kartu Kredit',
            'cash' => 'Tunai',
            'e_wallet' => 'E-Wallet'
        ];
        
        return [
            $rowNumber,
            $payment->payment_code,
            date('d/m/Y H:i', strtotime($payment->created_at)),
            $paymentTypes[$payment->payment_type] ?? $payment->payment_type,
            $paymentMethods[$payment->payment_method] ?? $payment->payment_method,
            $payment->amount,
            $payment->payment_status == 'verified' ? 'Terverifikasi' : 'Pending'
        ];
    }
}