<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Scopes\PharmacyScope;

class Restock extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected static function booted()
    {
        static::addGlobalScope(new PharmacyScope);
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
