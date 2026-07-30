<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    // Whitelist the exact columns we allow to be saved directly
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'price',
        'quantity', // <-- ADDED: Crucial for inventory tracking
        'description',
        'image_url',
        'is_trending',
        'is_sold_out',
        'colors',
    ];

    /**
     * The attributes that should be cast.
     * Treats the 'colors' JSON column as a PHP array automatically.
     */
    protected $casts = [
        'colors' => 'array',
        'is_trending' => 'boolean',
        'is_sold_out' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // Relationship for multiple product images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}