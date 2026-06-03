<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'type',
        'file_path',
        'category',
        'description',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Full public URL of the media file.
     */
    public function getFileUrlAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get full URL using asset helper if path exists.
     */
    public function getFileUrlDisplayAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }
        return asset('storage/' . $this->file_path);
    }

    /**
     * Human-readable type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'video' => 'Video',
            default => 'Gambar',
        };
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}