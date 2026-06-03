<?php

namespace App\Traits;

use App\Models\Gallery;

trait HasGallery
{
    /**
     * Get all galleries for this model
     */
    public function galleries()
    {
        $className = class_basename($this);
        $relation = strtolower($className);
        
        return $this->hasMany(Gallery::class, $relation . '_id');
    }
    
    /**
     * Get featured gallery for this model
     */
    public function featuredGallery()
    {
        $className = class_basename($this);
        $relation = strtolower($className);
        
        return $this->hasOne(Gallery::class, $relation . '_id')
                    ->where('is_featured', true);
    }
    
    /**
     * Get first image as attribute
     */
    public function getFirstImageAttribute()
    {
        $gallery = $this->galleries()->where('type', 'image')->first();
        return $gallery ? $gallery->file_path : null;
    }
    
    /**
     * Get all images
     */
    public function getImagesAttribute()
    {
        return $this->galleries()->where('type', 'image')->get();
    }
    
    /**
     * Get all videos
     */
    public function getVideosAttribute()
    {
        return $this->galleries()->where('type', 'video')->get();
    }
    
    /**
     * Get gallery count
     */
    public function getGalleryCountAttribute()
    {
        return $this->galleries()->count();
    }
    
    /**
     * Add image to gallery
     */
    public function addImage($file, $title = null, $isFeatured = false)
    {
        $path = $file->store('galleries/' . class_basename($this), 'public');
        $className = strtolower(class_basename($this));
        
        return $this->galleries()->create([
            'title' => $title ?? $this->name ?? $this->title ?? 'Image',
            'type' => 'image',
            'file_path' => $path,
            $className . '_id' => $this->id,
            'category' => $className,
            'is_featured' => $isFeatured,
            'sort_order' => $this->galleries()->count() + 1
        ]);
    }
}