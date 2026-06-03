<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOtpVerification extends Model
{
    const MAX_ATTEMPTS = 5;

    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
        'is_used',
        'used',
        'attempt_count',
        'locked_at',
    ];

    protected $casts = [
        'expires_at'    => 'datetime',
        'locked_at'     => 'datetime',
        'is_used'       => 'boolean',
        'attempt_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    public function isLocked(): bool
    {
        return $this->locked_at !== null;
    }

    public function incrementAttempt(): void
    {
        $this->increment('attempt_count');
        $this->refresh();

        if ($this->attempt_count >= self::MAX_ATTEMPTS) {
            $this->update(['locked_at' => now()]);
        }
    }

    public function remainingAttempts(): int
    {
        return max(0, self::MAX_ATTEMPTS - $this->attempt_count);
    }
}