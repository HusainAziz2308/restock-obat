<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Restock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'supplier_id',
        'quantity',
        'cost_price',
        'total_cost',
        'restock_date',
        'note',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'restock_date' => 'date',
            'cost_price' => 'decimal:2',
            'total_cost' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check() && Auth::user()->company_id) {
                $builder->whereHas('medicine');
            }
        });
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
