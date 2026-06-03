<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'category', 
        'description', 
        'price', 
        'is_available', 
        'is_recommended', 
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_recommended' => 'boolean'
    ];

    /**
     * Get all galleries for this menu
     */
    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'galleryable');
    }

    /**
     * Get the featured gallery for this menu
     */
    public function featuredGallery()
    {
        return $this->morphOne(Gallery::class, 'galleryable')
                    ->where('is_featured', true);
    }

    /**
     * Get first image URL (helper)
     */
    public function getFirstImageUrlAttribute()
    {
        $gallery = $this->galleries()->where('type', 'image')->first();
        return $gallery ? asset('storage/' . $gallery->file_path) : null;
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}