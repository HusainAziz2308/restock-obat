<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    private const IMAGE_PLACEHOLDER = 'https://placehold.co/300x300?text=No+Image';

    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
        'expired_date',
        'image',
        'category_id',
        'unit_id',
    ];

    protected function casts(): array
    {
        return [
            'expired_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return self::IMAGE_PLACEHOLDER;
        }

        $image = ltrim(str_replace('\\', '/', $this->image), '/');

        if (str_starts_with($image, 'obat/')) {
            return $this->publicAssetIfExists('storage/' . $image);
        }

        $legacyPath = 'images/obat/' . $image;

        if (file_exists(public_path($legacyPath))) {
            return asset($legacyPath);
        }

        return $this->publicAssetIfExists('storage/obat/' . $image);
    }

    private function publicAssetIfExists(string $path): string
    {
        return file_exists(public_path($path)) ? asset($path) : self::IMAGE_PLACEHOLDER;
    }
}
