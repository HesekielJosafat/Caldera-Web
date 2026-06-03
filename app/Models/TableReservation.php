<?php
// app/Models/TableReservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'reservation_date',
        'reservation_time',
        'number_of_guests',
        'table_numbers',
        'special_requests',
        'status',
        'payment_status',
        'down_payment',
        'payment_proof',
        'transaction_id',
        'paid_at',
        'cancellation_reason',
        'confirmed_at',
        'cancelled_at',
        'user_id',
    ];

    protected $casts = [
        'table_numbers' => 'array',
        'reservation_date' => 'date',
        'reservation_time' => 'datetime:H:i:s',
        'down_payment' => 'decimal:2',
        'paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Payment (polymorphic)
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // Accessor untuk payment status label
    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'waiting_payment' => '<span class="badge bg-warning">Menunggu Pembayaran</span>',
            'payment_verified' => '<span class="badge bg-info">Pembayaran Diverifikasi</span>',
            'paid' => '<span class="badge bg-success">Lunas</span>',
            'unpaid' => '<span class="badge bg-danger">Belum Bayar</span>',
            default => '<span class="badge bg-secondary">' . $this->payment_status . '</span>',
        };
    }

    
}