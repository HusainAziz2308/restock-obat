<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\BelongsToPharmacy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   

class StockOut extends Model
{
    use HasFactory, BelongsToPharmacy;

    public const REASONS = [
        'Terjual' => 'Terjual',
        'Rusak' => 'Rusak',
        'Expired' => 'Expired',
        'Koreksi Stok' => 'Koreksi Stok',
        'Lainnya' => 'Lainnya',
    ];

    protected $fillable = [
        'pharmacy_id',
        'medicine_id',
        'quantity',
        'out_date',
        'reason',
        'note',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'out_date' => 'date',
        ];
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
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
