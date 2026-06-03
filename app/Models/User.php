<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, Notifiable;

    // ── OTP Send Limit ────────────────────────────────────────────────────────
    const OTP_SEND_MAX    = 3;   // maks kirim OTP per window
    const OTP_SEND_WINDOW = 10;  // window dalam menit

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
        'otp_send_count',
        'otp_send_window_start',
        'otp_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'password'               => 'hashed',
            'is_active'              => 'boolean',
            'otp_send_window_start'  => 'datetime',
            'otp_send_count'         => 'integer',
        ];
    }

    // =========================================================================
    // JWT Interface
    // =========================================================================

    /**
     * Get the identifier that will be stored in the JWT subject claim.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array of custom claims to add to the JWT payload.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'role'  => $this->role,
            'email' => $this->email,
            'name'  => $this->name,
        ];
    }

    // =========================================================================
    // Role Helpers
    // =========================================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // =========================================================================
    // OTP Send Rate Limiting
    // =========================================================================

    /**
     * Apakah user masih boleh meminta kirim OTP?
     * Batas: maksimal 3x dalam 10 menit.
     */
    public function canRequestOtp(): bool
    {
        if (
            $this->otp_send_window_start === null ||
            now()->diffInMinutes($this->otp_send_window_start) >= self::OTP_SEND_WINDOW
        ) {
            return true;
        }

        return $this->otp_send_count < self::OTP_SEND_MAX;
    }

    /**
     * Catat bahwa user baru saja meminta kirim OTP.
     */
    public function recordOtpSend(): void
    {
        if (
            $this->otp_send_window_start === null ||
            now()->diffInMinutes($this->otp_send_window_start) >= self::OTP_SEND_WINDOW
        ) {
            $this->update([
                'otp_send_count'        => 1,
                'otp_send_window_start' => now(),
            ]);
            return;
        }

        $this->increment('otp_send_count');
    }

    /**
     * Berapa menit lagi sampai bisa kirim OTP kembali.
     */
    public function otpSendCooldownMinutes(): int
    {
        if ($this->otp_send_window_start === null) {
            return 0;
        }

        $elapsed = now()->diffInMinutes($this->otp_send_window_start);
        return max(0, self::OTP_SEND_WINDOW - $elapsed);
    }

    // =========================================================================
    // Email Verification Override
    // =========================================================================

    /**
     * Override supaya tidak kirim link verifikasi bawaan Laravel.
     * Verifikasi menggunakan OTP manual.
     */
    public function sendEmailVerificationNotification(): void
    {
        // Sengaja dikosongkan — verifikasi pakai OTP manual
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    public function otpVerifications()
    {
        return $this->hasMany(EmailOtpVerification::class);
    }

    public function isOtpVerified(): bool
    {
        return (bool) $this->otp_verified;
    }
}