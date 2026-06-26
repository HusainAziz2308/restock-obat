<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use \App\Traits\BelongsToPharmacy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory, BelongsToPharmacy;

    public const TYPES = [
        'in' => 'Masuk',
        'out' => 'Keluar',
        'adjustment' => 'Koreksi',
    ];

    protected $fillable = [
        'pharmacy_id',
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

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
