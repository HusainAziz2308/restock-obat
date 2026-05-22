<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends Model
{
    use HasFactory;

    public const TYPES = [
        'in' => 'Masuk',
        'out' => 'Keluar',
        'adjustment' => 'Koreksi',
    ];

    protected $fillable = [
        'medicine_id',
        'type',
        'quantity',
        'before_stock',
        'after_stock',
        'source_type',
        'source_id',
        'note',
        'created_by',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
