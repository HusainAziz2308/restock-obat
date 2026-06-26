<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Traits\BelongsToPharmacy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restock extends Model
{
    use HasFactory, BelongsToPharmacy;

    protected $fillable = [
        'pharmacy_id',
        'medicine_id',
        'quantity',
        'restock_date',
        'note',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'restock_date' => 'date',
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
