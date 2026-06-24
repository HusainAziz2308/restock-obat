<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $fillable = [
        'name', 'description', 'original_price', 'discount_percent', 
        'period', 'is_featured', 'badge', 'button_text', 'features'
    ];

    // Mengubah format JSON dari database menjadi Array PHP secara otomatis
    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'discount_percent' => 'integer',
    ];
}
