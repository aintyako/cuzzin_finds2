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
        'description',
        'image_url',
        'is_trending',
        'is_sold_out',
        'colors', // Added colors to the whitelist
    ];

    /**
     * The attributes that should be cast.
     * This tells Laravel to treat the 'colors' JSON column as a PHP array.
     */
    protected $casts = [
        'colors' => 'array',
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