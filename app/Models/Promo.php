<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner_image',
        'discount_type',
        'discount_value',
        'promo_code',
        'promo_type',
        'min_purchase',
        'max_discount',
        'start_date',
        'end_date',
        'applicable_for',
        'max_usage',
        'used_count',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'applicable_for' => 'array',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2'
    ];

    /**
     * Relasi ke menu (many-to-many)
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'promo_menu')
                    ->withPivot('special_price')
                    ->withTimestamps();
    }

    /**
     * Relasi ke events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Scope untuk promo aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /**
     * Scope berdasarkan tipe promo
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('promo_type', $type);
    }

    /**
     * Cek apakah promo masih berlaku
     */
    public function isValid()
    {
        return $this->is_active && 
               now()->between($this->start_date, $this->end_date) &&
               ($this->max_usage === null || $this->used_count < $this->max_usage);
    }

    /**
     * Hitung diskon
     */
    public function calculateDiscount($amount)
    {
        $discount = 0;
        
        if ($this->discount_type === 'percentage') {
            $discount = $amount * ($this->discount_value / 100);
        } else {
            $discount = $this->discount_value;
        }
        
        // Batasi dengan max discount jika ada
        if ($this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }
        
        // Batasi dengan min purchase
        if ($amount < $this->min_purchase) {
            $discount = 0;
        }
        
        return $discount;
    }

    /**
     * Gunakan promo (increment usage)
     */
    public function usePromo()
    {
        $this->increment('used_count');
    }
}