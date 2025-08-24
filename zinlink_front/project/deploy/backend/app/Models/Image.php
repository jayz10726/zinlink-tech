<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'category',
        'alt_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scope for active images
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Scope for images by category
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    // Scope for ordered images
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Get full image URL
    public function getFullUrlAttribute(): string
    {
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }
        
        return url('/storage/' . ltrim($this->image_url, '/'));
    }

    // Get alt text or fallback
    public function getAltTextAttribute($value): string
    {
        return $value ?: $this->name;
    }
}
