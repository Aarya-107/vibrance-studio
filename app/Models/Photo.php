<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category',
        'image_path',
        'is_featured',
        'taken_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'taken_at' => 'date'
    ];

    // Scopes
    public function scopeByCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('title', 'like', "%{$term}%")
                         ->orWhere('author', 'like', "%{$term}%");
        }
        return $query;
    }

    // Accessors
    public function getCategoryLabelAttribute()
    {
        return strtoupper($this->category);
    }

    public function getExcerptAttribute()
    {
        return \Str::limit($this->title, 20);
    }
}
