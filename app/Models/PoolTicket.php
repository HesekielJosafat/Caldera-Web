<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoolTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'visit_date',
        'visit_time',
        'number_of_tickets',
        'ticket_type',
        'price_per_ticket',
        'total_amount',
        'payment_status',
        'payment_method',
        'payment_proof',
        'status',
        'used_at',
        'user_id'
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime',
        'used_at' => 'datetime',
        'price_per_ticket' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Generate ticket code otomatis saat membuat tiket baru
        static::creating(function ($ticket) {
            $ticket->ticket_code = 'TKT-' . strtoupper(uniqid());
        });

        // Hitung total amount otomatis
        static::creating(function ($ticket) {
            $ticket->total_amount = $ticket->number_of_tickets * $ticket->price_per_ticket;
        });
    }

    /**
     * Relasi ke User (customer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Polymorphic relasi ke payments
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    /**
     * Scope untuk tiket aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope berdasarkan tanggal kunjungan
     */
    public function scopeVisitDate($query, $date)
    {
        return $query->where('visit_date', $date);
    }

    /**
     * Scope berdasarkan status pembayaran
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Cek kapasitas kolam untuk tanggal tertentu
     */
    public static function checkCapacity($date, $time = null)
    {
        $maxCapacity = 50; // Kapasitas maksimal kolam
        
        $ticketsSold = self::where('visit_date', $date)
            ->where('status', '!=', 'cancelled')
            ->sum('number_of_tickets');
        
        return [
            'available' => max(0, $maxCapacity - $ticketsSold),
            'total' => $maxCapacity,
            'sold' => $ticketsSold,
            'is_full' => ($maxCapacity - $ticketsSold) <= 0
        ];
    }

    /**
     * Check if ticket can be used
     */
    public function canBeUsed()
    {
        return $this->status === 'active' && 
               $this->payment_status === 'paid' &&
               $this->visit_date >= now()->format('Y-m-d');
    }

    /**
     * Mark ticket as used
     */
    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now()
        ]);
    }

    /**
     * Cancel ticket
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);
    }

    /**
     * Get ticket type label
     */
    public function getTicketTypeLabelAttribute()
    {
        $labels = [
            'adult' => 'Dewasa',
            'child' => 'Anak-anak',
            'family' => 'Keluarga'
        ];
        
        return $labels[$this->ticket_type] ?? $this->ticket_type;
    }

    /**
     * Get status label with badge
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => '<span class="badge bg-success">Aktif</span>',
            'used' => '<span class="badge bg-secondary">Digunakan</span>',
            'expired' => '<span class="badge bg-danger">Kadaluarsa</span>',
            'cancelled' => '<span class="badge bg-warning">Dibatalkan</span>'
        ];
        
        return $labels[$this->status] ?? '<span class="badge bg-info">' . $this->status . '</span>';
    }

    /**
     * Get payment status label
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'unpaid' => '<span class="badge bg-danger">Belum Bayar</span>',
            'paid' => '<span class="badge bg-success">Lunas</span>'
        ];
        
        return $labels[$this->payment_status] ?? '<span class="badge bg-info">' . $this->payment_status . '</span>';
    }
}