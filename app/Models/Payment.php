<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code',
        'payable_type',
        'payable_id',
        'amount',
        'payment_type',
        'payment_method',
        'bank_name',
        'account_number',
        'account_name',
        'payment_proof',
        'payment_status',
        'transaction_id',
        'notes',
        'customer_notes',
        'verified_at',
        'expired_at',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi polymorphic
    public function payable()
    {
        return $this->morphTo();
    }

    // Relasi ke user (admin yang verify)
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessor status label
    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}