<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_photo',
        'rating',
        'comment',
        'service_type',
        'visit_date',
        'is_approved',
        'is_featured',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'visit_date' => 'date',
        'approved_at' => 'datetime'
    ];

    /**
     * Relasi ke user yang approve
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope untuk testimonial yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope untuk testimonial yang belum disetujui
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope untuk testimonial featured (unggulan)
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope berdasarkan rating
     */
    public function scopeRating($query, $min = 4)
    {
        return $query->where('rating', '>=', $min);
    }

    /**
     * Scope berdasarkan service type
     */
    public function scopeServiceType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    /**
     * Get rating stars as array
     */
    public function getRatingStarsAttribute()
    {
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        return [
            'full' => $fullStars,
            'half' => $halfStar,
            'empty' => $emptyStars
        ];
    }

    /**
     * Get rating stars HTML
     */
    public function getRatingStarsHtmlAttribute()
    {
        $stars = '';
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5;
        
        for ($i = 1; $i <= $fullStars; $i++) {
            $stars .= '<i class="fas fa-star text-warning"></i>';
        }
        
        if ($halfStar) {
            $stars .= '<i class="fas fa-star-half-alt text-warning"></i>';
        }
        
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        for ($i = 1; $i <= $emptyStars; $i++) {
            $stars .= '<i class="far fa-star text-warning"></i>';
        }
        
        return $stars;
    }

    /**
     * Approve testimonial
     */
    public function approve($adminId = null)
    {
        $this->is_approved = true;
        $this->approved_at = now();
        if ($adminId) {
            $this->approved_by = $adminId;
        }
        $this->save();
        
        return $this;
    }

    /**
     * Reject testimonial
     */
    public function reject()
    {
        $this->is_approved = false;
        $this->approved_at = null;
        $this->approved_by = null;
        $this->save();
        
        return $this;
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured()
    {
        $this->is_featured = !$this->is_featured;
        $this->save();
        
        return $this;
    }
}