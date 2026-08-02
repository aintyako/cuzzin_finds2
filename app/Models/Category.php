<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function normalizeSlug(string $value): string
    {
        $normalized = Str::of($value)
            ->trim()
            ->lower()
            ->replace(['&', '/', '\\', ' '], ['and', '-', '-'])
            ->replaceMatches('/[^a-z0-9]+/', '-');

        $slug = $normalized->trim('-')->toString();

        $aliases = [
            'skincare' => 'skincare',
            'skin-care' => 'skincare',
            'skin care' => 'skincare',
            'beauty' => 'beauty',
            'clothes' => 'clothes',
            'clotes' => 'clothes',
            'cloth' => 'clothes',
        ];

        return $aliases[$slug] ?? $slug;
    }
}
