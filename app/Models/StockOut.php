<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    public const REASONS = [
        'Terjual' => 'Terjual',
        'Rusak' => 'Rusak',
        'Expired' => 'Expired',
        'Koreksi Stok' => 'Koreksi Stok',
        'Lainnya' => 'Lainnya',
    ];

    protected $fillable = [
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
}
